<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
          crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"
            integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ=="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap-filestyle.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="container">
    <h2>Bootstrap File upload demo</h2>


    <div class="form-group">
        <label>Bootstrap style button 1</label>
        <input type="file" id="BSbtndanger">
    </div>
    <div class="form-group">
        <label>Bootstrap style button 2</label>
        <input type="file" id="BSbtnsuccess">
    </div>
    <div class="form-group">
        <label>Bootstrap style button 3</label>
        <input type="file" id="BSbtninfo">
    </div>

</div>
<script>
    $('#BSbtndanger').filestyle({
        buttonName: 'btn-danger',
        buttonText: ' File selection'
    });
    $('#BSbtnsuccess').filestyle({
        buttonName: 'btn-success',
        buttonText: ' Open'
    });
    $('#BSbtninfo').filestyle({
        buttonName: 'btn-info',
        buttonText: ' Select a File'
    });
</script>

</body>
</html>

