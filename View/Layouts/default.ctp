<!DOCTYPE html>
<html>
<head>

    <?php echo $this->Html->charset(); ?>


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>
        <?php echo $this->fetch( 'title' ); ?>
    </title>
    <?php
    echo $this->Html->meta( 'icon' );

    echo $this->Html->css( [
        //'cake.generic',
        'bootstrap.min',
        'bootstrap-custom.min',
        'bootstrap-custom2.min',
        'style'
    ] );


    echo $this->Html->script( [
        'jquery.min',
        'bootstrap.min',
        'bootstrap.file-input.min',
        'jquery.load'
    ] );

    echo $this->fetch( 'meta' );
    echo $this->fetch( 'css' );
    echo $this->fetch( 'script' );
    ?>
</head>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<body>

<nav class="navbar navbar-masthead navbar-default navbar-fixed-top">
    <div class="container">
        <div class="col-lg-12">
        <div class="navbar-header">
            <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>-->
            <?php echo $this->Html->link('secufiles', '/', ['class' => 'navbar-brand']); ?>
        </div>
        <!--<div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </div>
        </div>
        <!--/.navbar-collapse -->
    </div>
</nav>


<div id="container" class="container">

    <div class="row">
        <div class="col-lg-12">
            <div id="content">

                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch( 'content' ); ?>

            </div>
        </div>
    </div>

    <footer>
        <p>open source by <a href="mailto:dev@patrickhafner.de?Subject=Hi Pat!">patrick hafner<a></p>
        <a href="https://github.com/patrickhafner/" target="_blank">
            <small>share and collaborate on github :)</small><br/><br/>
            <?php echo $this->Html->image('github.png', ['class' => 'icon-small']); ?>
        </a>
        <a href="http://cakephp.org/" target="_blank">
            <?php echo $this->Html->image('cake-logo.png', ['class' => 'icon-small']); ?>
        </a>

    </footer>
</div>
</body>
</html>
