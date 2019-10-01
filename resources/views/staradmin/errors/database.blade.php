<!DOCTYPE html> 
<html> 
<head> <title>Be right back.</title> 
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"> 

<style> 
    html, body { 
       height: 100%; 
    }
 
    body { 
       margin: 0; 
       padding: 0; 
       width: 100%; 
       color: #B0BEC5; 
       display: table; 
       font-weight: 100; 
       font-family: 'Lato'; 
    } 

    .container { 
       text-align: center; 
       display: table-cell; 
       vertical-align: middle; 
    }
 
    .content { 
       text-align: center; 
       display: inline-block; 
    }
 
    .title { 
       font-size: 72px; 
       margin-bottom: 40px; 
    } 

    .no-connection-list {
      font-size: 3rem;
    padding: 2.4rem;
    }

    .no-connection-list li {
    color: #666;
    font-size: 2.6rem;
    padding-bottom: 2rem;
    text-align: center;
  }

  .no-connection-background {
}

.no-connection-background img {
    width: 70%;
    }

.no-connection-list .line1 {
    color: #333;
    font-size: 3.6rem;
    padding: 1rem;
}

.no-connection-list .line2 {
    color: #ccc;
    font-size: 2.8rem;
    padding:1rem;
}

.no-connection-list .btn-refresh {
    background-color: #ff466f;
    font-size: 3.2rem;
    border-radius: 1rem;
    color: #fff;
    padding: 2rem;
    text-align: center;
    margin: 1rem 15rem;
}

</style> 
<script>
//这个统计代码。
var hmt = hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?5e39d74009d8416a3c77c62c47158471";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();

</script>

</head> 
<body> 
    <div class="container"> 
         
      <ul class="no-connection-list">
          <li>
            <div class="no-connection-background">
                <img src="/clientapp/images/no-connection/no-internet.png" />
            </div>
          </li>
          <li class="line1">网络竟然崩溃了</li>
          <li class="line2">别紧张，重新刷新试试</li>
          <div class="btn-refresh" onclick="javascript:location.reload();">重新刷新</div>
      </ul>
    </div> 
</body> 
</html>