import time
from datetime import datetime
import requests
import tinytuya

REGION = "us" # see documentaion for choosing server region
APIKEY = "xxxxxxxxxxxxxxxxx"
APISEC = "xxxxxxxxxxxxxxxxx"
DEVICEID = 'xxxxxxxxxxxxxxxxx'
SLEEP_TIME = 2

if __name__ == "__main__":
    myPlug = tinytuya.Cloud(REGION, APIKEY, APISEC, DEVICEID)

    temp_data = {"time":0, "current":0, "voltage":0, "power":0, "onoff": "off"}
    threshold = 1000 # threshold a washing machine current
    ontime = 0
    offtime = 0

    while True:
        status_result = myPlug.getstatus(DEVICEID) # Retrieve the current status of the device
        
        timestamp = status_result["t"]  # Unit: milliseconds
        cur_time = datetime.fromtimestamp(timestamp / 1000)
        print("Current Time: ", cur_time)
        
        # Retrieve and print the current, power, and voltage values
        cur_current = status_result["result"][3]["value"]  # Unit: mA
        cur_power   = status_result["result"][4]["value"]  # Unit: W
        cur_voltage = status_result["result"][5]["value"]  # Unit: 0.1V
        print("Current: %d mA\nVoltage: %d V\nPower: %d W" % (cur_current, cur_voltage / 10, cur_power))
        
        # Check if the current has changed significantly to switch the device on or off
        if cur_current - temp_data["current"] >= threshold and temp_data["onoff"] == "off":
            temp_data["onoff"] = "on"
            ontime = cur_time
            print("Turning On")
        elif cur_current - temp_data["current"] <= -threshold and temp_data["onoff"] == "on":
            temp_data["onoff"] = "off"
            offtime = cur_time
            print("Turning Off")
        
        # Update the temporary data with the current values
        temp_data["time"] = cur_time
        temp_data["current"] = cur_current
        temp_data["voltage"] = cur_voltage
        temp_data["power"] = cur_power
        if temp_data["onoff"] == "off" and ontime != 0:
            print("Operation Time: ", offtime - ontime)
        
        time.sleep(SLEEP_TIME)
