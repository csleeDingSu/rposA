<html>

<head>
    <title></title>
</head>

<body>

<div id="test">
    <p>{{$name}} this is test @{{ message }}</p>
    <input type = "text" id="input" v-model="message">
</div>

<script src="https://unpkg.com/vue@2.5.17/dist/vue.js"></script>

<script>
    new Vue({
        el:'#test',
        data: {
            message: 'hello1'
        }
    })
</script>
    
</body>

</html>