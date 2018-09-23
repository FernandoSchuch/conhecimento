        
        <script type="text/javascript" src="<?php echo base_url() ?>assests/js/jquery.min.js" ></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assests/js/bootstrap.min.js" ></script>        
        <?php if(isset($scripts) && count($scripts) > 0):?>
            <?php foreach ($scripts as $script):?>
                    <script type="text/javascript" src="<?php echo base_url()?>assests/js/<?php echo $script;?>" charset="iso-8859-1"></script>
            <?php endforeach;?>
	<?php endif;?>        
    </body>
</html>