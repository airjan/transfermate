<?php

$baseDirs = [
    'Database' => __DIR__ . '/Database/',  // Database 
    'Classes' => __DIR__ . '/Classes/',       // Class  
    'Models' =>  __DIR__ . '/Models/',	// Models 
    'Traits' =>  __DIR__ . '/Traits/',	// Traits for global function primary used for Models DRY applied   
];

// Register components
spl_autoload_register(function ($class) use ($baseDirs) {
   
    foreach ($baseDirs as $namespace => $baseDir) {
       
        if (strpos($class, $namespace) === 0) {
            
            $relativeClass = substr($class, strlen($namespace));
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
            
            
            if (file_exists($file)) {
            	
                require $file;
                return;
            } 
        }
    }
});

?>