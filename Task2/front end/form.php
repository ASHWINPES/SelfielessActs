<!DOCTYPE html>
<html lang="en" >

<head>
  <title>Upload act</title>
  <link rel="stylesheet" href="form.css">
</head>

<body>

  <div class="user">
    <header class="user__header">
        <h3 class="user__title">Upload act</h3>
    </header>
    
    <form class="form">
        
        <div class="form__group">
            <input type="text" placeholder="Enter caption" class="form__input" name="caption" id="caption" required>
        </div>

        <div class="form__group">
            <select name="cat" id="cat_list" style="width: 340px; height: 30px">

            </select> 
        </div>
        
        <div class="form__group">
            <label id="#bb" class="form__input"> Choose Picture
              <input type="file" name="uploadimage" id="upload_file">
            <label id="#bb">        
        </div>
        <input type="submit" class="btn" value="UPLAOD"  onclick="event.preventDefault(); upload_info()" >
    </form>
</div>

<script type="text/javascript">
    public_ip = 'http://54.174.92.235:5000';
    const Http = new XMLHttpRequest();
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
              //alert(k);
              e = document.createElement("option");
              e.setAttribute("value",k);
              e.innerHTML = k;
              sel.appendChild(e);
        }

    }
  }


  function upload_info() {
    data = {};

    var e = document.getElementById("cat_list");
    var categoryName = e.options[e.selectedIndex].value;
    console.log(categoryName);
    //alert(categoryName);

    file = document.getElementById('upload_file').files[0];


    caption_ele = document.getElementById("caption");
    caption = caption_ele.value;
    //alert(caption)

    upvotes = 0

    username = "test_user"

    date = new Date();

    timestamp = date.getDate() + '-' + String(parseInt(date.getMonth()) + 1)+ '-' + date.getFullYear() + ':' + date.getSeconds() + '-' + date.getMinutes() + '-' +date.getHours()

    actID = parseInt(date.getFullYear() +  String(parseInt(date.getMonth()) + 1) + date.getDate()  + date.getHours() + date.getMinutes() +date.getSeconds()+ date.getMilliseconds())

    data['actId'] = actID
    data['upvotes'] = upvotes
    data['caption'] = caption
    data['categoryName'] = categoryName
    data['username'] = username
    data['timestamp'] = timestamp

   reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
    //alert(reader.result)
    data['imgB64'] = reader.result.slice(reader.result.search(',')+1);

    const Http = new XMLHttpRequest();
    const url=public_ip+'/api/v1/acts';
    Http.open("POST", url);
    Http.setRequestHeader("Content-type", "application/json;charset=UTF-8");
    Http.send(JSON.stringify(data));


    console.log(JSON.stringify(data));
    Http.onreadystatechange= function()
    {
      if (Http.readyState ==4)
      {
        window.location.href = "index.php";
      }
    }
  } 
}
</script>

</body>
</html>