<?php

/**
 * Autoloader to load classes based on their namespace.
 *
 * This maps the class namespaces to specific directories, 
 * and when a class is needed, it automatically includes 
 * the corresponding file from the appropriate directory.
 *
 * @package    TransferMateExam
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */
$baseDirs = [
    'Database' => __DIR__ . '/Database/',  // Maps to Database folder 
    'Classes' => __DIR__ . '/Classes/',    // Maps to  Class folder  
    'Models' =>  __DIR__ . '/Models/',    // Maps to  Models  folder
    'Traits' =>  __DIR__ . '/Traits/',    // Maps to Traits folder  Models DRY applied  for create and update   
];

// Register components
spl_autoload_register(
    function ($class) use ($baseDirs) {
   
        foreach ($baseDirs as $namespace => $baseDir) {
       
            if (strpos($class, $namespace) === 0) {
            
                $relativeClass = substr($class, strlen($namespace));
                $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
            
                if (file_exists($file)) {
                    include $file;
                    return;
                } 
            }
        }
    }
);

?>
