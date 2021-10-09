<!DOCTYPE html>
<html lang="en" >

<head>
  <title>Add/Delete categoty</title>
  <link rel="stylesheet" href="form.css">
</head>

<body>

  <div class="user">
    <header class="user__header">
        <h3 class="user__title">Add/Delete categoty</h3>
    </header>
    
    <form class="form">
      

        <div class="add_del">
            <select name="option" id="option_list" style="width: 340px; height: 30px" onchange="add_input_ele(this)">
              <option value="Add" >Add</option>
              <option value="Delete" >Delete</option>
            </select> 
        </div>

        <div class="categories" style="display: none;">
            <select name="cat" id="cat_list" style="width: 340px; height: 30px">
            </select> 
        </div>

        <div class="cat_name" >
        <input type="text" placeholder="Enter caption" class="form__input" name="Category Name" id="Category_Name" required>
        </div>
        
        <input type="submit" class="btn" value="Submit"  onclick="event.preventDefault(); upload_info()" >
    </form>
</div>
  
<script type="text/javascript">
  const Http = new XMLHttpRequest();
    public_ip = 'http://54.174.92.235:5000';
    const url=public_ip+'/api/v1/categories';
    Http.open("GET", url);
    Http.send();
    keys=[];
    Http.onreadystatechange= function()
    {
      if (Http.readyState ==4 && Http.status==200)
      {
        response_data = Http.responseText;
        response_data = JSON.parse(response_data)
        for(k in response_data)
        {
              var sel = document.querySelector('#cat_list');
    
              e = document.createElement("option");
              e.setAttribute("value",k);
              e.innerHTML = k;
              sel.appendChild(e);
        }
    }
  }
  
  function add_input_ele(inp){
    if(inp.value=="Add")
    {
      document.querySelector('.cat_name').style.display = "block";
      document.querySelector('.categories').style.display = "none";
    }
    else
    {
      document.querySelector('.cat_name').style.display = "none";
      document.querySelector('.categories').style.display = "block";
    }
  }

  function upload_info() {
    var e = document.getElementById("option_list");
    var categoryName = e.options[e.selectedIndex].value;
    //alert(categoryName);
    data = [];
    const Http = new XMLHttpRequest();

    if(categoryName=="Add")
    {
      category_ele = document.getElementById("Category_Name");
      category = category_ele.value;
      //alert(category);
      data.push(category);
      const url=public_ip+'/api/v1/categories';
      Http.open("POST", url);
      Http.setRequestHeader("Content-type", "application/json;charset=UTF-8");
      Http.send(JSON.stringify(data));
    }
    else
    {
      var e = document.getElementById("cat_list");
      var categoryName = e.options[e.selectedIndex].value;
      //alert(categoryName);
      const url=public_ip+'/api/v1/categories/'+categoryName;
      Http.open("DELETE", url);
      Http.send();
    }
        Http.onreadystatechange= function()
    {
      if (Http.readyState ==4)
      {
        window.location.href = "index.php";
      }
    }
}
</script>

</body>
</html>