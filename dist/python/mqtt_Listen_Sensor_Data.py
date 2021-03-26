#------------------------------------------
#--- Author: Pradeep Singh
#--- Date: 20th January 2017
#--- Version: 1.0
#--- Python Ver: 2.7
#--- Details At: https://iotbytes.wordpress.com/store-mqtt-data-from-sensors-into-sql-database/
#------------------------------------------

import paho.mqtt.client as mqtt
from store_Sensor_Data_to_DB import sensor_Data_Handler

# MQTT Settings 
MQTT_Broker = "localhost"
MQTT_Port = 1883
Keep_Alive_Interval = 45
MQTT_Topic = "esp32WeatherStation/#"

#Subscribe to all Sensors at Base Topic
def on_connect(client, userdata, flags, rc):
	print("Connected with result code "+str(rc))
	mqttc.subscribe(MQTT_Topic)

#Save Data into DB Table
def on_message(client, userdata, msg):
	# This is the Master Call for saving MQTT Data into DB
	# For details of "sensor_Data_Handler" function please refer "sensor_data_to_db.py"
	print("MQTT Data Received...")
	print("MQTT Topic: " + msg.topic)
	payload = str(msg.payload)[2:-1]  
	print("Data: " + payload)
	sensor_Data_Handler(msg.topic, payload)

mqttc = mqtt.Client()

# Assign event callbacks
mqttc.on_message = on_message
mqttc.on_connect = on_connect

# Connect
mqttc.connect(MQTT_Broker, int(MQTT_Port), int(Keep_Alive_Interval))

# Continue the network loop
mqttc.loop_forever()
