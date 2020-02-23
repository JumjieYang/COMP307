<p>
    <form id="postForm">
        Title <input type="text" name = "title"/><br />
        Content<br /><textarea name="content" style="width:400px;height:150px"></textarea><br/>
        <input id ="postSubmit" type ="button" value="Submit post">
</form>
</p>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$('#postSubmit').on('click',function(event)
{
    var title = $("input[name=title]").val();
    var content = $("textarea[name=content").val();
    if(title && content)
    {
        $.ajax(
        {
            type: "POST",
            url :"create_post.php",
            data : {title:title, content :content},
            dataType: "json",
            success: function(data)
            {
                var output ="<fieldset><b>Title: "+data.title+"</b><br/>By: "+data.creator+"<br/>"+ data.content+"</fieldset><br/>";
                $('#posts').append(output);
            }
        }
        );
        
    }
    else
    {
        alert("input invalid");
    }
})
</script>