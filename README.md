
PHP image processor. 

Simple use: 
```PHP
$image = $_FILES['image'];
$proc = new imageProcessor($image);
$proc->resample();
```


Example: http://jordanrandles.co.uk/examples/PHP-image-processor/example/
