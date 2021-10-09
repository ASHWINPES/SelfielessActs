from flask import *
import hashlib
import datetime
import base64
from flask_cors import CORS

#with open("database.json", "r") as jsonFile:
#   data = json.load(jsonFile)
#users = {"adarsh":"3809ddoih39"} # values are username:password
#categories = {"cat1":3,"cat2":4} # category name:no_of_acts
#encoded_strings = []
#image_file = open('uploads/cat1/1.jpg', 'rb')
#encoded_strings.append(base64.b64encode(image_file.read()))
#image_file = open('uploads/cat1/2.jpg', 'rb')
#encoded_strings.append(base64.b64encode(image_file.read()))
#image_file = open('uploads/cat1/3.jpg', 'rb')
#encoded_strings.append(base64.b64encode(image_file.read()))

#encoded_strings[0] = str(encoded_strings[0])[2:len(encoded_strings[0])-2]
#encoded_strings[1] = str(encoded_strings[1])[2:len(encoded_strings[1])-2]
#encoded_strings[2] = str(encoded_strings[2])[2:len(encoded_strings[2])-2]

#acts = [{"actId":1,"username":"user1","timestamp":"2019-02-09:12-09-15","caption":"hello1","categoryName":"cat2","upvotes":0,"imgB64":encoded_string1},{"actId":2,"username":"user2","timestamp":"2019-02-09:12-09-15","caption":"hello2","categoryName":"cat1","upvotes":0,"imgB64":encoded_string2},{"actId":3,"username":"user3","timestamp":"2019-02-09:12-09-15","caption":"hello3","categoryName":"cat1","upvotes":0,"imgB64":encoded_string3}]# [actId,username,timestamp,caption,categoryName,upvotes,imgB64]
#acts = [{"actId":1,"username":"user1","timestamp":"2019-02-09:12-09-15","caption":"hello1","categoryName":"c1","upvotes":0,"imgB64":encoded_string1}]
users = {}
categories = {}
acts = []

# for i in range(len(acts)):
# 	acts[i]['imgB64'] = encoded_strings[i]

with open("database.json", "r") as jsonFile:
    data = json.load(jsonFile)
#users = {"adarsh":"3809ddoih39"} # values are username:password
#categories = {"cat1":3,"cat2":4} # category name:no_of_acts
encoded_strings = []
image_file = open('uploads/waste_management/1.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))
image_file = open('uploads/waste_management/2.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))
image_file = open('uploads/waste_management/3.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))

image_file = open('uploads/household_work/4.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))
image_file = open('uploads/household_work/5.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))
image_file = open('uploads/household_work/6.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))

image_file = open('uploads/helping_animals/7.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))
image_file = open('uploads/helping_animals/8.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))
image_file = open('uploads/helping_animals/9.jpg', 'rb')
encoded_strings.append(base64.b64encode(image_file.read()))


encoded_strings[0] = str(encoded_strings[0])[2:len(encoded_strings[0])-2]
encoded_strings[1] = str(encoded_strings[1])[2:len(encoded_strings[1])-2]
encoded_strings[2] = str(encoded_strings[2])[2:len(encoded_strings[2])-2]

encoded_strings[3] = str(encoded_strings[3])[2:len(encoded_strings[3])-2]
encoded_strings[4] = str(encoded_strings[4])[2:len(encoded_strings[4])-2]
encoded_strings[5] = str(encoded_strings[5])[2:len(encoded_strings[5])-2]

encoded_strings[6] = str(encoded_strings[6])[2:len(encoded_strings[6])-2]
encoded_strings[7] = str(encoded_strings[7])[2:len(encoded_strings[7])-2]
encoded_strings[8] = str(encoded_strings[8])[2:len(encoded_strings[8])-2]

#acts = [{"actId":1,"username":"user1","timestamp":"2019-02-09:12-09-15","caption":"hello1","categoryName":"cat2","upvotes":0,"imgB64":encoded_string1},{"actId":2,"username":"user2","timestamp":"2019-02-09:12-09-15","caption":"hello2","categoryName":"cat1","upvotes":0,"imgB64":encoded_string2},{"actId":3,"username":"user3","timestamp":"2019-02-09:12-09-15","caption":"hello3","categoryName":"cat1","upvotes":0,"imgB64":encoded_string3}]# [actId,username,timestamp,caption,categoryName,upvotes,imgB64]
#acts = [{"actId":1,"username":"user1","timestamp":"2019-02-09:12-09-15","caption":"hello1","categoryName":"c1","upvotes":0,"imgB64":encoded_string1}]
users = data['users']
categories = data['categories']
acts = data['acts']
for i in range(len(acts)):
	acts[i]['imgB64'] = encoded_strings[i]


app = Flask(__name__)
api = CORS(app)

#1
@app.route('/api/v1/users',methods=['POST'])
def add_user():
	if not request.json or not 'username' in request.json or not 'password' in request.json:
		return jsonify({}),400
	username = request.json['username']
	if username in users.keys():
		return jsonify({}),400
	else:
		users[username] = hashlib.sha1(request.json['password'].encode()).hexdigest()
		print(users)
		return jsonify({}),201
#2
@app.route('/api/v1/users/<username>',methods=['DELETE'])
def remove_user(username):
	print(username)
	if username in users.keys():
		del users[username]
		return jsonify({}),200
	else:
		return jsonify({}),404

#3. list categories
@app.route('/api/v1/categories',methods=['GET'])
def list_categories():
	if categories!={}:
		return jsonify(categories),200
	else:
		return jsonify({}),205

#4. add category
@app.route('/api/v1/categories',methods=['POST'])
def add_category():
	if request.json[0] in categories.keys():
		return jsonify({}),400
	else:
		new_cat = request.json[0]
		categories[new_cat] = 0
		print(categories)
		return jsonify({}),201

#5. remove a category
@app.route('/api/v1/categories/<string:categoryName>',methods=['DELETE'])
def delete_category(categoryName):
	if categoryName not in categories.keys():
		return jsonify({}),400
	else:
		del categories[categoryName]
		print(categories)
		return jsonify({}),200


#7. List number of acts for a given category
@app.route('/api/v1/categories/<string:categoryName>/acts/size',methods=['GET'])
def ListNumberOfActsForACategory(categoryName):
    if categoryName not in categories.keys():
        return jsonify([]),204
    val = int(categories[categoryName])
    return jsonify(list([val])),200

#8
@app.route('/api/v1/categories/<string:categoryName>/acts',methods=['GET'])
def acts_in_range(categoryName):

	start  = request.args.get('start', None)
	end  = request.args.get('end', None)
	if start==None or end==None:
		return ListActsForAGivenCategory(categoryName)

	if categoryName not in categories.keys():
		return jsonify({}),405
	new_acts = [x for x in acts if x['categoryName']==categoryName]

	if len(new_acts)<end or start<0:
		return jsonify({}),405
	if (end-start+1 >100):
		return jsonify({}),413
	sorted_acts = sorted(new_acts,key = lambda x: datetime.datetime(
							int(x['timestamp'].split(':')[0].split('-')[0]),\
							int(x['timestamp'].split(':')[0].split('-')[1]),\
							int(x['timestamp'].split(':')[0].split('-')[2]),\
							int(x['timestamp'].split(':')[1].split('-')[2]),\
							int(x['timestamp'].split(':')[1].split('-')[1]),\
							int(x['timestamp'].split(':')[1].split('-')[0])),reverse=True)
	return jsonify(sorted_acts[start:end+1]),200

#6. List acts for a given category (when total #acts is less than 100)
@app.route('/api/v1/categories/<string:categoryName>/acts',methods=['GET'])
def ListActsForAGivenCategory(categoryName):
    print("its here")
    if categoryName not in categories.keys():
    	return jsonify([]),204
    l = []
    for act in acts:
        if act["categoryName"] == categoryName:
            l.append(act)

    if(len(l)>0):
        if(len(l)>100):
            return jsonify([]),413
        else:
            return jsonify(l),200
    else:
        return jsonify([]),204


#9 Upvote Act
@app.route('/api/v1/acts/upvote',methods=['POST'])
def UpvoteAct():
    if not request.json:
        print(request.json)
        return jsonify({}),400
    print(request.json)
    actId = int(request.json[0])
    print("actId is ",actId)
    for i in range(len(acts)):
        if acts[i]['actId']==actId:
            print("hello")
            acts[i]['upvotes']+=1
            print(acts[i]['upvotes'])
            l = acts[i]['upvotes']
            return jsonify(l),200
    return jsonify({}),405

#10 remove an act
@app.route('/api/v1/acts/<string:act_id>',methods=['DELETE'])
def delete_act(act_id):
	flag = 0;
	for act in acts:
		if act['actId'] == int(act_id):
			flag = 1
			acts.remove(act)

	if flag == 0:
		return jsonify({}),400

	return jsonify({}),200

#11
@app.route('/api/v1/acts',methods=['POST'])
def upload_act():
	if not request.json or not 'actId' in request.json or not 'username' in request.json or not 'timestamp' in request.json or not 'caption' in request.json or not 'categoryName' in request.json or not 'imgB64' in request.json:
		return jsonify({}),400
	else:
		act = {
			"actId":int(request.json['actId']),
			"username":request.json['username'],
			"timestamp":request.json['timestamp'],
			"caption":request.json['caption'],
			"categoryName":request.json['categoryName'],
			"upvotes":request.json['upvotes'],
			"imgB64":request.json['imgB64']
		}
		acts.append(act)
		if act['categoryName'] not in categories.keys():
			categories[act['categoryName']] = 0
		categories[act['categoryName']]+=1
		return jsonify({}),201

@app.route('/api/v1/allacts',methods=['GET'])
def get_all_acts():
	if acts == []:
		return jsonify([]),400
	else:
		return jsonify(acts),200

@app.route('/addact')
def show_form():
	return render_template('form.php')

@app.route('/adduser')
def adduser():
	return render_template('add_user.php')

@app.route('/category_mod')
def category_change():
	return render_template('category_changes.php')

@app.route('/')
def home():
	return render_template('index.php',categories=categories,acts=acts)

if __name__ == '__main__':
    #app.run()
    app.run(host="0.0.0.0",port=5000)
