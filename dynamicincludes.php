<?php

/***************************************\
# Created By: Rickey Otano a.k.a pein87 #
# License: Creative Commons 2 BSD       #
# Creation Date: 5/29/12                #
# Usage: Java-ish package system for    #
# dynamic includes of files from a      #
# folder. Include single files          #
# list of files, or whole folders       #
# I am not at fault for any misuse,     #
# damage or issues this may create      #
# and this is provided as is with       #
# no guarentees of any kind             #
\***************************************/

    /* use interface so others can implement it their own way */
    interface packages
    {
        /* function that includes php files */
        public function package($dir,$files,$type);
        
        /* function that include tpl */
        public function packageTpl($dir,$files,$type);
        
        /* function that includes phar files */
        public function packagePhar($dir,$files,$type);
    }
    
    class import implements packages
    {
    
        public function package($dir,$files,$type)
        {
            /* arrays of required values or expected values of $files and $type */
            $fileField = array("*","ALL"); // inlcude all files if $files equals on of them
            $typeField = array("INC","REQ","INC_O","REQ_O"); // type of include to perform
            
            /* dir and file handles */
            $dirHandle = opendir($dir); // directory handle(opens dir to reading)
            $resources; // blank variable that will hold all the resources
            $dirLen = strlen($dir); // number of characters in the directory text
            
            /* check if dir has / added at the end or not and if not add it*/
            if(substr($dir,$dirLen - 1,$dirLen) == "/" && substr($dir,0,1) == "/")
            {
                $dir = $dir . "/"; // add / to dir path's end
            }
            else if(substr($dir,$dirLen - 1,$dirLen) == "/" && substr($dir,0,1) !== "/")
            {
                $dir = "/" . $dir . "/"; // add / to dir path on front and back
            }
            else
            {
                /* correct value is there so do nothing */
            }
            
            if($dirHandle)
            {
                
                /* check if $files is * or ALL so we can include every .php file in that directory, if not and its an array include the specific files or if its not then include the single file */
                if($files == $fileField[0] || $files == $fileField[1] || $files == strtoupper($fileField[1]))
                {
                    /* loop through folder */
                    while(($resources == readdir($dirHandle)) !== false)
                    {
                        /* do nothing if they are the . and .. files */
                        if($resources !== "." || $resources !== "..")
                        {
                            $rLen = strlen($resources); // length of resource one each turn
                            
                            /* check if the end has .php extenstion */
                            if(substr($resources,$rLen - 4, $rLen) == ".php")
                            {
                                /* include files based on the include type which is universal for every file */
                                switch($type)
                                {
                                    case "INC":
                                        include($resources);
                                    break;
                                    
                                    case "REQ":
                                        require($resources);
                                    break;
                                    
                                    case "INC_O":
                                        include_once($resources);
                                    break;
                                    
                                    case "REQ_O":
                                        require_once($resources);
                                    break;
                                    
                                    default:
                                        include($resources);
                                    break;
                                }
                            }
                        }
                    }
                }
                else if(is_array($files))
                {
            
                    /* get array size for loop and set count variable */
                    $aSize = count($files); // array item count
                    $i; // counter
                
                    /* loop through the directory and include only the selected files */
                    while(($resources = readdir($dirHandle)) !== false)
                    {
                        /* loop through files to see if they are and include file*/
                        for($i = 0; $i < $aSize; $i++)
                        {
                            /* check if the resources is a include file */
                            if($resources == $files[$i] . ".php")
                            {
                                /* do the include or require depending on the value of $type and set default to include */
                                switch($type)
                                {
                                    case "INC":
                                        /* include files */
                                        include($dir . $files[$i] . ".php");
                                    break;
                                    
                                    case "REQ":
                                        /* require files */
                                        require($dir . $files[$i] . ".php");
                                    break;
                                    
                                    case "INC_O":
                                        /* include once files */
                                        include($dir . $files[$i] . ".php");
                                    break;
                                    
                                    case "REQ_O":
                                        /* require once files */
                                        require_once($dir . $files[$i] . ".php");
                                    break;
                                
                                    default:
                                        /* default is include */
                                        include($dir . $files[$i] . ".php");
                                    break;
                                }
                            
                            }
                        }
                    }
                }
                else
                {
                    /* check if the files exists and if so include or require it, used on single files only */
                    if(file_exists($dir . $files . ".php"))
                    {
                        switch($type)
                        {
                            case "INC":
                                /* include files */
                                include($dir . $files . ".php");
                            break;
                                    
                            case "REQ":
                                /* require files */
                                require($dir . $files . ".php");
                            break;
                                    
                            case "INC_O":
                                /* include once files */
                                include($dir . $files . ".php");
                            break;
                                    
                            case "REQ_O":
                                /* require once files */
                                require_once($dir . $files . ".php");
                            break;
                                
                            default:
                                /* default is include */
                                include($dir . $files . ".php");
                            break;
                        }
                    }
                }
            }
            else if($dir == "" || $dir == NULL)
            {
                /* check if $files is * or ALL so we can include every .php file in that directory, if not and its an array include the specific files or if its not then include the single file */
                $dirHandle = opendir(getcwd()); // current folder in use so get current working folder
                
                if($files == $fileField[0] || $files == $fileField[1] || $files == strtoupper($fileField[1]))
                {
                    /* loop through folder */
                    while(($resources == readdir($dirHandle)) !== false)
                    {
                        /* do nothing if they are the . and .. files */
                        if($resources !== "." || $resources !== "..")
                        {
                            $rLen = strlen($resources); // length of resource one each turn
                            
                            /* check if the end has .php extenstion */
                            if(substr($resources,$rLen - 4, $rLen) == ".php")
                            {
                                /* include files based on the include type which is universal for every file */
                                switch($type)
                                {
                                    case "INC":
                                        include($resources);
                                    break;
                                    
                                    case "REQ":
                                        require($resources);
                                    break;
                                    
                                    case "INC_O":
                                        include_once($resources);
                                    break;
                                    
                                    case "REQ_O":
                                        require_once($resources);
                                    break;
                                    
                                    default:
                                        include($resources);
                                    break;
                                }
                            }
                        }
                    }
                }
                else if(is_array($files))
                {
            
                    /* get array size for loop and set count variable */
                    $aSize = count($files); // array item count
                    $i; // counter
                
                    /* loop through the directory and include only the selected files */
                    while(($resources = readdir($dirHandle)) !== false)
                    {
                        /* loop through files to see if they are and include file*/
                        for($i = 0; $i < $aSize; $i++)
                        {
                            /* check if the resources is a include file */
                            if($resources == $files[$i] . ".php")
                            {
                                /* do the include or require depending on the value of $type and set default to include */
                                switch($type)
                                {
                                    case "INC":
                                        /* include files */
                                        include($files[$i] . ".php");
                                    break;
                                    
                                    case "REQ":
                                        /* require files */
                                        require($files[$i] . ".php");
                                    break;
                                    
                                    case "INC_O":
                                        /* include once files */
                                        include($files[$i] . ".php");
                                    break;
                                    
                                    case "REQ_O":
                                        /* require once files */
                                        require_once($files[$i] . ".php");
                                    break;
                                
                                    default:
                                        /* default is include */
                                        include($files[$i] . ".php");
                                    break;
                                }
                            
                            }
                        }
                    }
                }
                else
                {
                    /* check if the files exists and if so include or require it, used on single files only */
                    if(file_exists($files . ".php"))
                    {
                        switch($type)
                        {
                            case "INC":
                                /* include files */
                                include($files . ".php");
                            break;
                                    
                            case "REQ":
                                /* require files */
                                require($files . ".php");
                            break;
                                    
                            case "INC_O":
                                /* include once files */
                                include($files . ".php");
                            break;
                                    
                            case "REQ_O":
                                /* require once files */
                                require_once($files . ".php");
                            break;
                                
                            default:
                                /* default is include */
                                include($files . ".php");
                            break;
                        }
                    }
                }
            }
        
        }
        
        public function packageTpl($dir,$files,$type)
        {
            /* arrays of required values or expected values of $files and $type */
            $fileField = array("*","ALL"); // inlcude all files if $files equals on of them
            $typeField = array("INC","REQ","INC_O","REQ_O"); // type of include to perform
            
            /* dir and file handles */
            $dirHandle = opendir($dir); // directory handle(opens dir to reading)
            $resources; // blank variable that will hold all the resources
            $dirLen = strlen($dir); // number of characters in the directory text
            
            /* check if dir has / added at the end or not and if not add it*/
            if(substr($dir,$dirLen - 1,$dirLen) == "/" && substr($dir,0,1) == "/")
            {
                $dir = $dir . "/"; // add / to dir path's end
            }
            else if(substr($dir,$dirLen - 1,$dirLen) == "/" && substr($dir,0,1) !== "/")
            {
                $dir = "/" . $dir . "/"; // add / to dir path on front and back
            }
            else
            {
                /* correct value is there so do nothing */
            }
            
            if($dirHandle)
            {
                
                /* check if $files is * or ALL so we can include every .php file in that directory, if not and its an array include the specific files or if its not then include the single file */
                if($files == $fileField[0] || $files == $fileField[1] || $files == strtoupper($fileField[1]))
                {
                    /* loop through folder */
                    while(($resources == readdir($dirHandle)) !== false)
                    {
                        /* do nothing if they are the . and .. files */
                        if($resources !== "." || $resources !== "..")
                        {
                            $rLen = strlen($resources); // length of resource one each turn
                            
                            /* check if the end has .php extenstion */
                            if(substr($resources,$rLen - 4, $rLen) == ".tpl")
                            {
                                /* include files based on the include type which is universal for every file */
                                switch($type)
                                {
                                    case "INC":
                                        include($resources);
                                    break;
                                    
                                    case "REQ":
                                        require($resources);
                                    break;
                                    
                                    case "INC_O":
                                        include_once($resources);
                                    break;
                                    
                                    case "REQ_O":
                                        require_once($resources);
                                    break;
                                    
                                    default:
                                        include($resources);
                                    break;
                                }
                            }
                        }
                    }
                }
                else if(is_array($files))
                {
            
                    /* get array size for loop and set count variable */
                    $aSize = count($files); // array item count
                    $i; // counter
                
                    /* loop through the directory and include only the selected files */
                    while(($resources = readdir($dirHandle)) !== false)
                    {
                        /* loop through files to see if they are and include file*/
                        for($i = 0; $i < $aSize; $i++)
                        {
                            /* check if the resources is a include file */
                            if($resources == $files[$i] . ".tpl")
                            {
                                /* do the include or require depending on the value of $type and set default to include */
                                switch($type)
                                {
                                    case "INC":
                                        /* include files */
                                        include($dir . $files[$i] . ".tpl");
                                    break;
                                    
                                    case "REQ":
                                        /* require files */
                                        require($dir . $files[$i] . ".tpl");
                                    break;
                                    
                                    case "INC_O":
                                        /* include once files */
                                        include($dir . $files[$i] . ".tpl");
                                    break;
                                    
                                    case "REQ_O":
                                        /* require once files */
                                        require_once($dir . $files[$i] . ".tpl");
                                    break;
                                
                                    default:
                                        /* default is include */
                                        include($dir . $files[$i] . ".tpl");
                                    break;
                                }
                            
                            }
                        }
                    }
                }
                else
                {
                    /* check if the files exists and if so include or require it, used on single files only */
                    if(file_exists($dir . $files . ".tpl"))
                    {
                        switch($type)
                        {
                            case "INC":
                                /* include files */
                                include($dir . $files . ".tpl");
                            break;
                                    
                            case "REQ":
                                /* require files */
                                require($dir . $files . ".tpl");
                            break;
                                    
                            case "INC_O":
                                /* include once files */
                                include($dir . $files . ".tpl");
                            break;
                                    
                            case "REQ_O":
                                /* require once files */
                                require_once($dir . $files . ".tpl");
                            break;
                                
                            default:
                                /* default is include */
                                include($dir . $files . ".tpl");
                            break;
                        }
                    }
                }
            }
            else if($dir == "" || $dir == NULL)
            {
                /* check if $files is * or ALL so we can include every .php file in that directory, if not and its an array include the specific files or if its not then include the single file */
                
                $dirHandle = opendir(getcwd()); // current folder in use so get current working folder
                
                if($files == $fileField[0] || $files == $fileField[1] || $files == strtoupper($fileField[1]))
                {
                    /* loop through folder */
                    while(($resources == readdir($dirHandle)) !== false)
                    {
                        /* do nothing if they are the . and .. files */
                        if($resources !== "." || $resources !== "..")
                        {
                            $rLen = strlen($resources); // length of resource one each turn
                            
                            /* check if the end has .php extenstion */
                            if(substr($resources,$rLen - 4, $rLen) == ".tpl")
                            {
                                /* include files based on the include type which is universal for every file */
                                switch($type)
                                {
                                    case "INC":
                                        include($resources);
                                    break;
                                    
                                    case "REQ":
                                        require($resources);
                                    break;
                                    
                                    case "INC_O":
                                        include_once($resources);
                                    break;
                                    
                                    case "REQ_O":
                                        require_once($resources);
                                    break;
                                    
                                    default:
                                        include($resources);
                                    break;
                                }
                            }
                        }
                    }
                }
                else if(is_array($files))
                {
            
                    /* get array size for loop and set count variable */
                    $aSize = count($files); // array item count
                    $i; // counter
                
                    /* loop through the directory and include only the selected files */
                    while(($resources = readdir($dirHandle)) !== false)
                    {
                        /* loop through files to see if they are and include file*/
                        for($i = 0; $i < $aSize; $i++)
                        {
                            /* check if the resources is a include file */
                            if($resources == $files[$i] . ".tpl")
                            {
                                /* do the include or require depending on the value of $type and set default to include */
                                switch($type)
                                {
                                    case "INC":
                                        /* include files */
                                        include($files[$i] . ".tpl");
                                    break;
                                    
                                    case "REQ":
                                        /* require files */
                                        require($files[$i] . ".tpl");
                                    break;
                                    
                                    case "INC_O":
                                        /* include once files */
                                        include($files[$i] . ".tpl");
                                    break;
                                    
                                    case "REQ_O":
                                        /* require once files */
                                        require_once($files[$i] . ".tpl");
                                    break;
                                
                                    default:
                                        /* default is include */
                                        include($files[$i] . ".tpl");
                                    break;
                                }
                            
                            }
                        }
                    }
                }
                else
                {
                    /* check if the files exists and if so include or require it, used on single files only */
                    if(file_exists($files . ".tpl"))
                    {
                        switch($type)
                        {
                            case "INC":
                                /* include files */
                                include($files . ".tpl");
                            break;
                                    
                            case "REQ":
                                /* require files */
                                require($files . ".tpl");
                            break;
                                    
                            case "INC_O":
                                /* include once files */
                                include($files . ".tpl");
                            break;
                                    
                            case "REQ_O":
                                /* require once files */
                                require_once($files . ".tpl");
                            break;
                                
                            default:
                                /* default is include */
                                include($files . ".tpl");
                            break;
                        }
                    }
                }
            }
        
        }
        
        
        public function packagePhar($dir,$files,$type)
        {
            /* arrays of required values or expected values of $files and $type */
            $fileField = array("*","ALL"); // inlcude all files if $files equals on of them
            $typeField = array("INC","REQ","INC_O","REQ_O"); // type of include to perform
            
            /* dir and file handles */
            $dirHandle = opendir($dir); // directory handle(opens dir to reading)
            $resources; // blank variable that will hold all the resources
            $dirLen = strlen($dir); // number of characters in the directory text
            
            /* check if dir has / added at the end or not and if not add it*/
            if(substr($dir,$dirLen - 1,$dirLen) == "/" && substr($dir,0,1) == "/")
            {
                $dir = $dir . "/"; // add / to dir path's end
            }
            else if(substr($dir,$dirLen - 1,$dirLen) == "/" && substr($dir,0,1) !== "/")
            {
                $dir = "/" . $dir . "/"; // add / to dir path on front and back
            }
            else
            {
                /* correct value is there so do nothing */
            }
            
            if($dirHandle)
            {
                
                /* check if $files is * or ALL so we can include every .php file in that directory, if not and its an array include the specific files or if its not then include the single file */
                if($files == $fileField[0] || $files == $fileField[1] || $files == strtoupper($fileField[1]))
                {
                    /* loop through folder */
                    while(($resources == readdir($dirHandle)) !== false)
                    {
                        /* do nothing if they are the . and .. files */
                        if($resources !== "." || $resources !== "..")
                        {
                            $rLen = strlen($resources); // length of resource one each turn
                            
                            /* check if the end has .php extenstion */
                            if(substr($resources,$rLen - 5, $rLen) == ".phar")
                            {
                                /* include files based on the include type which is universal for every file */
                                switch($type)
                                {
                                    case "INC":
                                        include($resources);
                                    break;
                                    
                                    case "REQ":
                                        require($resources);
                                    break;
                                    
                                    case "INC_O":
                                        include_once($resources);
                                    break;
                                    
                                    case "REQ_O":
                                        require_once($resources);
                                    break;
                                    
                                    default:
                                        include($resources);
                                    break;
                                }
                            }
                        }
                    }
                }
                else if(is_array($files))
                {
            
                    /* get array size for loop and set count variable */
                    $aSize = count($files); // array item count
                    $i; // counter
                
                    /* loop through the directory and include only the selected files */
                    while(($resources = readdir($dirHandle)) !== false)
                    {
                        /* loop through files to see if they are and include file*/
                        for($i = 0; $i < $aSize; $i++)
                        {
                            /* check if the resources is a include file */
                            if($resources == $files[$i] . ".phar")
                            {
                                /* do the include or require depending on the value of $type and set default to include */
                                switch($type)
                                {
                                    case "INC":
                                        /* include files */
                                        include($dir . $files[$i] . ".phar");
                                    break;
                                    
                                    case "REQ":
                                        /* require files */
                                        require($dir . $files[$i] . ".phar");
                                    break;
                                    
                                    case "INC_O":
                                        /* include once files */
                                        include($dir . $files[$i] . ".phar");
                                    break;
                                    
                                    case "REQ_O":
                                        /* require once files */
                                        require_once($dir . $files[$i] . ".phar");
                                    break;
                                
                                    default:
                                        /* default is include */
                                        include($dir . $files[$i] . ".phar");
                                    break;
                                }
                            
                            }
                        }
                    }
                }
                else
                {
                    /* check if the files exists and if so include or require it, used on single files only */
                    if(file_exists($dir . $files . ".phar"))
                    {
                        switch($type)
                        {
                            case "INC":
                                /* include files */
                                include($dir . $files . ".phar");
                            break;
                                    
                            case "REQ":
                                /* require files */
                                require($dir . $files . ".phar");
                            break;
                                    
                            case "INC_O":
                                /* include once files */
                                include($dir . $files . ".phar");
                            break;
                                    
                            case "REQ_O":
                                /* require once files */
                                require_once($dir . $files . ".phar");
                            break;
                                
                            default:
                                /* default is include */
                                include($dir . $files . ".phar");
                            break;
                        }
                    }
                }
            }
            else if($dir == "" || $dir == NULL)
            {
                /* check if $files is * or ALL so we can include every .php file in that directory, if not and its an array include the specific files or if its not then include the single file */
                
                $dirHandle = opendir(getcwd()); // current folder in use so get current working folder
                
                if($files == $fileField[0] || $files == $fileField[1] || $files == strtoupper($fileField[1]))
                {
                    /* loop through folder */
                    while(($resources == readdir($dirHandle)) !== false)
                    {
                        /* do nothing if they are the . and .. files */
                        if($resources !== "." || $resources !== "..")
                        {
                            $rLen = strlen($resources); // length of resource one each turn
                            
                            /* check if the end has .php extenstion */
                            if(substr($resources,$rLen - 5, $rLen) == ".phar")
                            {
                                /* include files based on the include type which is universal for every file */
                                switch($type)
                                {
                                    case "INC":
                                        include($resources);
                                    break;
                                    
                                    case "REQ":
                                        require($resources);
                                    break;
                                    
                                    case "INC_O":
                                        include_once($resources);
                                    break;
                                    
                                    case "REQ_O":
                                        require_once($resources);
                                    break;
                                    
                                    default:
                                        include($resources);
                                    break;
                                }
                            }
                        }
                    }
                }
                else if(is_array($files))
                {
            
                    /* get array size for loop and set count variable */
                    $aSize = count($files); // array item count
                    $i; // counter
                
                    /* loop through the directory and include only the selected files */
                    while(($resources = readdir($dirHandle)) !== false)
                    {
                        /* loop through files to see if they are and include file*/
                        for($i = 0; $i < $aSize; $i++)
                        {
                            /* check if the resources is a include file */
                            if($resources == $files[$i] . ".phar")
                            {
                                /* do the include or require depending on the value of $type and set default to include */
                                switch($type)
                                {
                                    case "INC":
                                        /* include files */
                                        include($files[$i] . ".phar");
                                    break;
                                    
                                    case "REQ":
                                        /* require files */
                                        require($files[$i] . ".phar");
                                    break;
                                    
                                    case "INC_O":
                                        /* include once files */
                                        include($files[$i] . ".phar");
                                    break;
                                    
                                    case "REQ_O":
                                        /* require once files */
                                        require_once($files[$i] . ".phar");
                                    break;
                                
                                    default:
                                        /* default is include */
                                        include($files[$i] . ".phar");
                                    break;
                                }
                            
                            }
                        }
                    }
                }
                else
                {
                    /* check if the files exists and if so include or require it, used on single files only */
                    if(file_exists($files . ".phar"))
                    {
                        switch($type)
                        {
                            case "INC":
                                /* include files */
                                include($files . ".phar");
                            break;
                                    
                            case "REQ":
                                /* require files */
                                require($files . ".phar");
                            break;
                                    
                            case "INC_O":
                                /* include once files */
                                include($files . ".phar");
                            break;
                                    
                            case "REQ_O":
                                /* require once files */
                                require_once($files . ".phar");
                            break;
                                
                            default:
                                /* default is include */
                                include($files . ".phar");
                            break;
                        }
                    }
                }
            }
        
        }
    }
?>