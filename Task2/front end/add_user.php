<!DOCTYPE html>
<html lang="en" >

<head>
  <title>Register</title>
  <link rel="stylesheet" href="form.css">
</head>

<body>

  <div class="user">
    <header class="user__header">
        <h3 class="user__title">Register</h3>
    </header>
    
    <form class="form">

        <div class="add_rem">
            <select name="option" id="option_list" style="width: 340px; height: 30px" onchange="add_input_ele(this)">
              <option value="Add" >Add user</option>
              <option value="Remove" >Remove user</option>
            </select> 
        </div>

        <div class="form__group">
            <input type="text" placeholder="Username" class="form__input" name="caption" id="username" required>
        </div>

        <div class="password">
            <input type="text" placeholder="Password" class="form__input" name="password" id="password" required>
        </div>
        
        <input type="submit" class="btn" value="Register"  onclick="event.preventDefault(); upload_info()" >
    </form>
</div>
  
<script type="text/javascript">
    public_ip = 'http://54.174.92.235:5000';
    function add_input_ele(inp)
    {
        if(inp.value=="Remove")
            document.querySelector(".password").style.display = "None";
        else
            document.querySelector(".password").style.display = "block";
    }



  function upload_info() {
    
    var e = document.getElementById("option_list");
    var categoryName = e.options[e.selectedIndex].value;
    //alert(categoryName);

    username_ele = document.getElementById("username");
    username = username_ele.value;
    //alert(username);
    data = {};
    const Http = new XMLHttpRequest();
    if(categoryName=="Add")
    {
        password_ele = document.getElementById("password");
        password = password_ele.value;
        //alert(password);
        data['username'] = username
        data['password'] = password    


        const url=public_ip+'/api/v1/users';
        Http.open("POST", url);
        Http.setRequestHeader("Content-type", "application/json;charset=UTF-8");
        Http.send(JSON.stringify(data));
        console.log(JSON.stringify(data)); 
    }
    else
    {
        const url=public_ip+'/api/v1/users/'+username;
        Http.open("DELETE", url);
        Http.send();
    }
    Http.onreadystatechange=(e)=>{
        if (Http.readyState ==4)
        {
        //console.log(Http.responseText)
        response_data = Http.responseText;
        response_data = JSON.parse(response_data)
        console.log(response_data);
        window.location.href = "index.php";
        }
    }
}
</script>

</body>
</html>