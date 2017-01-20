#include <UIPEthernet.h>

// Enter a MAC address for your controller below.
// Newer Ethernet shields have a MAC address printed on a sticker on the shield
byte mac[] = { 0xDE, 0xAD, 0xBD, 0xEF, 0xFE, 0xED };
// if you don't want to use DNS (and reduce your sketch size)
// use the numeric IP instead of the name for the server:
//IPAddress server(74,125,232,128);  // numeric IP for Google (no DNS)
char server[] = "192.168.1.68";    // name address for Google (using DNS)

// Set the static IP address to use if the DHCP fails to assign
IPAddress ip(192, 168, 1, 177);

// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;

// initialize get payload
String payload = "";
String appliances[] = {"TV", "Heater", "Computer", "Bulb"};

/* CURRENT MEASURING CODE */
const int analogIn = A0;
int mVperAmp = 100; // use 100 for 20A Module and 66 for 30A Module
int RawValue= 0;
int ACSoffset = 2500; 
double Voltage = 0;
double Amps = 0;

void read_current(){
   RawValue = analogRead(analogIn);
   Voltage = (RawValue / 1024.0) * 5000; // Gets you mV
   Amps = ((Voltage - ACSoffset) / mVperAmp);
   
   
   Serial.print("Raw Value = " ); // shows pre-scaled value 
   Serial.print(RawValue); 
   Serial.print("\t mV = "); // shows the voltage measured 
   Serial.print(Voltage,3); // the '3' after voltage allows you to display 3 digits after decimal point
   Serial.print("\t Amps = "); // shows the voltage measured 
   Serial.println(Amps,3); // the '3' after voltage allows you to display 3 digits after decimal point
   delay(2500); 
}


void send_request(){
  Serial.println("connecting...");
  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.println("connected");
    Serial.println("Payload: " + payload);
    // Make a HTTP request:
    client.println("GET /iot/add_to_database.php"+ payload +" HTTP/1.1");
    client.println("Host: 192.168.1.68");
    client.println("Connection: close");
    client.println();
  }
  else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  Serial.println("Payload sent.");
  delay(20);
}
void setup() {
  // Open serial communications and wait for port to open:
  Serial.begin(9600);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }

  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // try to congifure using IP address instead of DHCP:
    Ethernet.begin(mac, ip);
  }
  // give the Ethernet shield a second to initialize:
  delay(1000);  

}

void loop() {
  // if there are incoming bytes available
  // from the server, read them and print them:
  if (client.available()) {
    char c = client.read();
    Serial.print(c);
  }

  // read_current();

  payload="?";
  int value;
  for(int i = 0 ; i < 4 ; i++){
    value = random(200);
    payload += appliances[i] + "=" + value + "&";
    
  }
  send_request();
  
  // if the server's disconnected, stop the client:
  if (!client.connected()) {
    Serial.println();
    Serial.println("disconnecting.");
    client.stop();

    // do nothing forevermore:
    while (true);
  }

  delay(1000);
}
