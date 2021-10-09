<!DOCTYPE html>
<html>
<head>
	<title>SelfieLessActs</title>
	<link rel="stylesheet" href="index.css">
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
	<meta http-equiv="pragma" content="no-cache" />
</head>
<body>
	<div class="navbar">
		<h1 id="heading">SelfieLessActs</h1>

  		<button class="addact" onclick="upload_handler(this)">Add act</button>
  		<button class="adduser" onclick="upload_handler(this)">Add user</button>
  		<button class="category_mod" onclick="upload_handler(this)">Add/Delete category</button>
	</div>
	<div id="acts"></div>
	<a id="gen_pur_url" href="">

<script type="text/javascript">
	
	//template for act
	public_ip = 'http://54.174.92.235:5000';
	my_list = [];
	get_categories_util();
	var template = document.createElement('div');
	template.setAttribute('class','act_class');
	var img_t = document.createElement('img');
	img_t.setAttribute('class','img_t')
	var caption_t = document.createElement('h2');
	caption_t.setAttribute('class','caption_t');
	var upvote_t = document.createElement('button');
	upvote_t.setAttribute('class','upvote_t');
	
	upvote_t.innerHTML = "upvote";
	var upvote_c = document.createElement('h3');
	upvote_c.innerHTML = "0";
	upvote_t.appendChild(upvote_c);
	var delete_t = document.createElement('button');
	delete_t.setAttribute('class','delete_t');
	delete_t.innerHTML = "delete";
	var date_t = document.createElement('input');
	date_t.style.visibility = "hidden";

	//additional info
	var actId = document.createElement('h2');
	actId.style.visibility = "hidden";
	var categoryName = document.createElement('h2');
	categoryName.style.visibility = "hidden";
	var username = document.createElement('h2');
	username.style.visibility = "hidden";

	template.appendChild(img_t);
	template.appendChild(caption_t);
	template.appendChild(date_t);
	template.appendChild(upvote_t);
	template.appendChild(delete_t);
	template.appendChild(categoryName);
	template.appendChild(actId);
	template.appendChild(username);
	var act_div = document.querySelector('#acts');

	//var images_dir = "uploads/";

	//var form = document.querySelector(".addact");
	//form.addEventListener('click',upload_handler);
	all_acts = [];
	
	function get_categories_util()
	{
		const Http = new XMLHttpRequest();
		const url=public_ip + "/api/v1/categories";
		Http.open("GET", url);
		Http.send();
		
		Http.onreadystatechange=(e)=>{
			if (Http.readyState ==4 && Http.status==200)
		      {
		      	console.log(Http.status)
				//console.log(Http.responseText)
				response_data = Http.responseText;
				//alert(response_data);
				response_data = JSON.parse(response_data);
				parent = document.querySelector(".navbar");
				var i=1;
				for(var ele in response_data)
				{
					var button = document.createElement("button");
					//alert(ele);
					button.innerHTML = ele;
					button.setAttribute("id","c"+i);
					button.addEventListener('click',function(){
						load_acts(this);
					});
					parent.insertBefore(button,parent.children[i+1]);
					i+=1;
				}	
				getacts();	  
			}
	}
	}

	function getacts()
	{
		const Http = new XMLHttpRequest();
		const url=public_ip + "/api/v1/allacts";
		Http.open("GET", url);
		Http.send();
		Http.onreadystatechange=(e)=>{
			if (Http.readyState ==4 && Http.status==200)
		      {

				response_data = Http.responseText;
				response_data = JSON.parse(response_data);
				all_acts = response_data;
				document.querySelector("#c1").click();//will call load_acts
				alert("done loading acts");
			}

	}
	}

	function createAct(container,act_div,act)
	{
		//alert(path);
		console.log(act);
		newact = container.cloneNode(true);
		newact.children[0].setAttribute('src','data:image/jpg;base64,'+act["imgB64"]);
		newact.children[1].innerHTML = act['caption'];//caption
		newact.children[2].innerHTML = act['timestamp'];
		//alert('upvotes '+act['upvotes']);
		newact.children[3].children[0].innerHTML = act['upvotes'];
		newact.children[3].addEventListener('click',increment_c);
		newact.children[4].addEventListener('click',delete_act);
		newact.children[5].innerHTML = act['categoryName'];
		newact.children[6].innerHTML = act['actId'];
		newact.children[7].innerHTML = act['username'];
		if(act_div.firstChild==null)
			act_div.appendChild(newact);
		else
		{
			act_div.insertBefore(newact,act_div.children[0]);
		}
	}

	function increment_c()
	{

		//alert(this.nextSibling.nextSibling.nextSibling.innerHTML);
		data = [];
		data.push(this.nextSibling.nextSibling.nextSibling.innerHTML);
		//To make a post request
		const Http = new XMLHttpRequest();
		const url=public_ip + '/api/v1/acts/upvote';
		Http.open("POST", url);
		Http.setRequestHeader("Content-type", "application/json;charset=UTF-8");
		Http.send(JSON.stringify(data));
		Http.onreadystatechange=(e)=>{
		if (Http.readyState ==4 && Http.status==200)
		{
		console.log(Http.responseText)
		response_data = Http.responseText;

		response_data = JSON.parse(response_data)
		this.children[0].innerHTML = response_data;
		}		
		for(var i=0;i<all_acts.length;i++)
			{
				if(all_acts[i]["actId"]==data['actID'])
				{
					//alert("inc");
					all_acts[i]["upvotes"]+=1;
					break;
				}
			}	
	}
		

		//this.children[0] = response_data["count"]+"";
		/*var gen_pur = document.querySelector("#gen_pur_url");
		gen_pur.setAttribute("href","api/v1/acts/upvote");
		gen_pur.click();*/
	//category = this.nextSibling.nextSibling.innerHTML;
	//document.querySelector("#"+category).click();//will call load_acts

	}

	function delete_act()
	{
		var acts = document.querySelector('#acts');
		data = {};
		data['actID'] = this.nextSibling.nextSibling.innerHTML;
		//alert(data["actID"]);
		//To make a delete request
		const Http = new XMLHttpRequest();
		const url=public_ip+'/api/v1/acts/'+data['actID'];
		Http.open("DELETE", url);
		Http.setRequestHeader("Content-type", "application/json;charset=UTF-8");
		Http.send(JSON.stringify(data));
		Http.onreadystatechange=(e)=>{
			if (Http.readyState ==4 && Http.status==200)
		      {
		console.log(Http.responseText)
		response_data = Http.responseText;
		response_data = JSON.parse(response_data)
		console.log(response_data);
		}
		}
		acts.removeChild(this.parentNode);
		for(var i=0;i<all_acts.length;i++)
			{
				if(all_acts[i]["actId"]==data['actID'])
				{
					all_acts.splice(i,1);
				}
			}

	}

	function upload_handler(inp)
	{
		//alert(inp.innerHTML);
		var form_link = document.createElement('a');
		if(inp.innerHTML=="Add act")
			form_link.setAttribute('href','form.php');
		else if(inp.innerHTML=="Add user")
			form_link.setAttribute('href','add_user.php');
		else
			form_link.setAttribute('href','category_changes.php');
		var ret = form_link.click();
	}

	function load_acts(button)
	{
		clear_acts();
		//alert("in load acts");
		//console.log(all_acts[0]);
		for(var i=0;i<all_acts.length;i++)
		{
			//console.log(button.innerHTML);
			//console.log(all_acts[i]["categoryName"]);
			if(all_acts[i]["categoryName"]==button.innerHTML)
			{
				//alert(all_acts[i]["categoryName"]);
				createAct(template,act_div,all_acts[i]);
			}
		}
	}
	//document.querySelector("#c1").click();//will call load_acts


	function clear_acts()
	{
		while(act_div.hasChildNodes())
			act_div.removeChild(act_div.lastChild);
	}

	function change_colour(id)
	{
		var nav_bar = document.querySelector('.navbar');
		for(var i=1;i<=4;i++)
		{
			nav_bar.children[i].style.backgroundColor = "#37404f";
		}
		nav_bar.children[id].style.backgroundColor = "#2bbd97";	
	}
</script>
</body>
</html>
