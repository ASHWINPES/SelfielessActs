# SelfielessActs
Cloud Computing project with the use of Microservices
```
-----Algorithms used for Task 1-----
Algorithm Health_check:
// Checks if the server is functioning normally
if ( crash == True)
status_code ← 500
return status_code
try block
connect ← connection to database
Insert data to database
Select data from database
Delete data from database
status_code ← 200
return status_code
if any exception occured in try block
status_code ← 500
return status_code
Algorithm Crash_Server:
// Permanently disables an Acts container
global crash ← True
status_code ← 200
return status_code

-----Algorithms used for Task 2-----
Algorithm Run_Load_Balancer
Listen on Port 80
Accept requests from all hosts
Algorithm Load_Balancer ( request)
global port_index, active_ports
port_index ← (port_index + 1)%len(active_ports)
new_host_url ← “localhost:”+ active_ports[port_index]
url ← request.host_url replaced by new_host_url
method ← request.method
headers ← {key:value in request.headers such that key!=”Host”}
data ← request.get_data()
response ← Send http request having method, headers, data to url
return response.text, response.status_code, response.headers.items()

-----Algorithms used for Task 3-----
Algorithm Fault_Tolerance
global active_ports
while (True)
for port in active_ports
response ← send GET request to “http://localhost:port/api/v1/_health"
if (response.status_code == 500)
container_id ← fetch container id of container listening through port
stop container_id
new_container_id ← create new container with port_no ← port
sleep for 1s

-----Algorithms used for Task 4-----
Algorithm Auto_scaling
global active_ports, total_no_of_counts
Wait till first request is received
Start timer
end_request_count ← 0
while (True):
start_request_count ← total_no_of_counts
no_of_required_containers=(start_request_count - end_request_count )//20 + 1
required_container_ports ← [8000+i for i in
range(no_of_required_containers)]
if no_of_required_containers > len(active_ports)
for each container_port in required_container_ports
if container_port not in active_ports
create new container with port ← container_port
if no_of_containers < len(active_ports)
for each container_port in active_ports
if container_port not in required_container_ports
remove container with port ← container_port
end_request_count ← start_request_count
sleep for 2 mins

-----ADDITIONAL EXTENSIONS ABOVE GIVEN SPECIFICATIONS-----
We extend the auto scaling feature to be more generic, such that the scaling in and scaling
out of containers occurs based on user defined rules specifying how long the number of
requests parameter should be monitored, what the threshold limit for every t seconds
interval should be to trigger an action (which is scale in or out) and also the scale factor by
which we should scale out our containers or scale in.
Further extensions in this regard would be focussed at allowing more flexibility with the
parameter to be monitored as well based on user input rather than us considering only
number of requests for triggering a scaling action.
```
![Design](https://user-images.githubusercontent.com/31538383/136642463-f07dc518-383f-4f3d-8026-0ad37b932846.png)

The above figure pictorially portrays the architecture of our Acts EC2 setup. In the users
EC2 instance, we have only one container running with all requests related to
/api/v1/users url being routed to it by the Amazon AWS Load Balancer.            
