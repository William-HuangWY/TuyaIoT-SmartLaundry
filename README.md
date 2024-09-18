# TuyaIoT-SmartLaundry

This  project uses [_**Tuya's smart plugs**_](https://www.tuyaexpo.com/smart/electrical/indoor-plug---outlet/smart-plugs/CT9cn90yyaumny-CT9cn95ninmx4t-CT9cn9ryid3ecb) to monitor electricity usage of washing machines in dormitory settings. The smart plugs are equipped with sensors and wireless communication modules that regularly report data to Tuya Cloud. This data is then accessed via APIs to provide real-time monitoring and control through a website and a Line Bot.

> [See our Project Site](https://weiyinghuang.com/iot/nsysu-dormitory-washing-machine-mainpage.html)

## About Tuya

Tuya is a company that offers smart home and IoT solutions. Their products, including smart plugs, are designed using IoT technology to allow remote control and monitoring through the internet. The smart plug system integrates hardware, firmware, and software to enable real-time data collection and remote control. 

* ### Hardware Layer
    - **Microcontroller (MCU)**: Controls the plug, collects data, and communicates with the server.
    - **Current Sensor**: Measures the current consumed by the connected device.
    - **Voltage Sensor**: Monitors input voltage.
    - **Power Calculation Unit**: Computes power consumption based on current and voltage data.
    - **Wireless Communication Module**: Connects the plug to the internet (Wi-Fi, ZigBee), enabling remote control through mobile apps or other platforms.

* ### Firmware Layer
    - **Control Logic**: Handles sensor data and plug operations.
    - **Status Reporting**: Sends data to Tuya's cloud server periodically.
    - **Command Processing**: Executes user commands received from mobile apps or other platforms.

* ### Cloud Layer
    Tuya’s cloud platform processes and stores data from smart plugs. It provides APIs for developers to access this data.
    - **Cloud Storage and Data Processing**: Stores and processes data for user access.
    - **API**: Allows developers to interact with the data (e.g., using `tinytuya.Cloud()` from Python, `https://openapi.tuya` cURL http request from PHP, ...).

* ### Application Layer
    Users can control smart plugs using Tuya’s app or third-party applications (e.g., Alexa, Google Home, Mobile APP).
    - **Remote Control**: Operate the plug from anywhere.
    - **Scheduling**: Set timers for automatic operation.
    - **Energy Monitoring**: View power consumption data.
    - **Voice Control**: Control via voice assistants.

## Tuya Open APIs
- ## PHP Request
    For integrating Tuya Cloud API with PHP, we can use the `tuyapiphp` client library. Refer to [tuyapiphp](https://github.com/ground-creative/tuyapiphp.git) for details.
    
    For directly use of this module:

    * ### Include Functions
        - **Authentication**: Manages API key and secret for secure access.
        - **Device Control**: Control Tuya devices (e.g., on/off commands).
        - **Data Retrieval**: Fetch device status and data.
        - **Error Handling**: Handles and reports API error

    * ### Configuration
        - **Access token**: Get an access token to interact with Tuya Cloud.
        ``` php []
        require 'path/to/tuyapiphp/vendor/autoload.php'; // Using Composer or manual include the module

        $client_config =
        [
            'api_key' => 'your_api_key', // Tuya IoT platform `client_id`
            'api_secret' => 'your_api_secret', // Tuya IoT platform `client_secret`
            'baseUrl' => 'https://openapi.tuyaus.com'
        ];

        $tuya = new \tuyapiphp\TuyaApi( $config );
        $data = $tuya->token->get_new();
        $accessToken = $data->result->access_token;
        ```
- ## Python Request
    For integrating Tuya Cloud API with Python, we can use `tinytuya` client library. Refer to [pypi-tinytuya](https://pypi.org/project/tinytuya/) for details.

    For directly use of this module:

    * ### Include Functions
        - **Authentication**: Manages API key and secret for secure access.
        - **Device Control**: Send commands to Tuya devices (e.g., on/off).
        - **Data Retrieval**: Retrieve device status and data.
        - **Error Handling**: Manage API errors.

    * ### Configuration
        Ensure you install the library via pip:
        ```bash
        pip install tinytuya
        ```

        - **Access Token**: Obtain an access token to interact with Tuya Cloud.
        ```python
        import tinytuya

        # Setup Tuya device
        device = tinytuya.Device(
            'device_id',  # Tuya device ID
            'your_api_key',  # Tuya IoT platform `client_id`
            'your_api_secret',  # Tuya IoT platform `client_secret`
            'us'  # Tuya region (e.g., 'us', 'cn', 'eu')
        )

        # Authenticate and retrieve status
        device.login()
        status = device.status()
        print(status)
        ```

## Service
1. **Local Machine Host**
   - Use a local server environment to host the website files and manage the application.
   - Place website files in the server's document root directory and server scripts.
   - Access the local server via `http://localhost` or `http://127.0.0.1`.

2. **Remote Host**
   - Deploy the application on a VPS or hosting server. Set up the environment using SSH, run scripts.
   - Install and configure necessary software (e.g., Apache/Nginx, PHP, MySQL).
   - Deploy website files to the server's web root directory.
   - Configure firewall and security settings as needed.


## Getting Started
1. **Clone the Repository**

    ```bash
    git clone https://github.com/William-HuangWY/TuyaIoT-SmartLaundry.git
    ```

2. **Install Dependencies**

    Setup for required dependencies.

3. **Configuration**

    Set up your API keys, configure the environment, and ensure that your database and server settings are correctly applied.

4. **Running the Application**

    Deploy the application on your chosen hosting solution.

<!-- ## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. -->

## Acknowledgements
*For more information, please refer to the documentations:*
- [Group Note (zh-tw)](https://hackmd.io/@William8334551/Tuya-IOT)
- [pypi-tinytuya](https://pypi.org/project/tinytuya/)
- [tuyapiphp.git](https://github.com/ground-creative/tuyapiphp.git)
- [Tuya Official Documentation](https://www.tuya.com/)
- [Line Messaging API Documentation](https://developers.line.biz/en/docs/messaging-api/)
