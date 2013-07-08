<?php include'../layout.html';
if ($_GET['act'] == "countPosts") {
    $sql = mysql_query("SELECT * FROM `forum_messages` ORDER BY `message_id` DESC LIMIT 5");
    while($count = mysql_fetch_assoc($sql)) {
        echo "<b>".$count['message_id']."</b> - ".$count['message']."<br /><br />";
    }
}
?>
<script type="text/javascript">
function createRequestObject() {
    
        var req;
    
        if(window.XMLHttpRequest){
            // Firefox, Safari, Opera...
            req = new XMLHttpRequest();
        } else if(window.ActiveXObject) {
            // Internet Explorer 5+
            req = new ActiveXObject("Microsoft.XMLHTTP");
        } else {
            // There is an error creating the object,
            // just as an old browser is being used.
            alert('There was a problem creating the XMLHttpRequest object');
        }
    
        return req;
    
    }
    
    // Make the XMLHttpRequest object
    var http = createRequestObject();
    
    function sendRequest(act) {
        
        // Open PHP script for requests
        http.open('get', 'ajax.php?act='+act);
        http.onreadystatechange = handleResponse;
        http.send(null);
    
    }
    
    function handleResponse() {
    
        if(http.readyState == 4 && http.status == 200){
    
            // Text returned FROM PHP script
            var response = http.responseText;
    
            if(response) {
                // UPDATE ajaxTest content
                document.getElementById("countPosts").innerHTML = response;
                setTimeout(countPosts,20);
            }
    
        }
    }

    function countPosts() {
        sendRequest('countPosts');
    }';
</script>
<?php
include'../footer.html';
?>
