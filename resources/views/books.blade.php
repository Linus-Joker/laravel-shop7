<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Books</title>
</head>
<body>
    <p>hi i am Books</p>
    <button class="test">Button</button>



    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.js'></script>
    <script>
        //path 在自己更換
        $(function(){
            $('.test').click(function (e) {
                $.get("/api/products",function(data){
                    data_array = data.data;
                    console.log(data.status);
                    console.log(data.message);
                    for (let index = 0; index < data_array.length; index++) {
                        const element = data_array[index];
                        console.log(element.name)
                    }
                });
            });
        });

    </script>
</body>
</html>
