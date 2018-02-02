
<?php
header("Content-type: text/html; charset=utf-8");
ini_set('display_errors', 0 );
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');

function SureRemoveFiles($dir) {
    
    global $contador;

    //Atributos a serem pesquisados. ,'200x200','300x300'
    $blacklist = [

        '[0-9]{1,}x[0-9]{1,}',


    ];

    //Caminho setado pelo usuário.
    $dh = opendir($dir);
    if($dh == false) {
?>
    <div class="alert alert-danger text-center">
        <h4>Diretório <?php echo " \"$dir\" "; ?> não encontrado </h4>
    </div>
<?php
        return;
    }
    
    while (false !== ($obj = readdir($dh))) 
    {
            
        if($obj == '.' || $obj == '..') continue;
        $file = realpath($dir.'/'.$obj);
        if (is_dir($file) === true)
        {
            $teste = $dir.'/'.$obj;
            SureRemoveFiles($teste);
        }
        else if (is_file($file) === true)
        {
            foreach($blacklist as $pattern) 
            {
                $filter = "/$pattern/";
                preg_match($filter, $obj, $matches, PREG_OFFSET_CAPTURE);
                if(count($matches)){
                    $contador++;
                    //echo $dir . '  ' . $obj . '<hr>';       
                    if (unlink($dir.'/'.$obj)) 
                    {
                      echo $dir . ' - ' . $obj . "<h6>APAGADO </h6><hr>";                        
                    } else {
                      echo "Não foi possível apagar arquivo $obj e $pattern ";
                    } 
                }
            }
        }
    }
    closedir($dh);
} 