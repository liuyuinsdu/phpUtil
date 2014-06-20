<?php
    error_reporting(0);
    if($argc!=3){
		echo "参数格式错误";
		exit();
	}
	$file = $argv[1];
	$type = $argv[2];
	
	$content = file_get_contents($file);
	$array = explode("\n", $content); 
	if(count($array)==1)
	{
		echo "切分失败\r\n";
		exit(1);
	}
	if($type==1){

		if(stristr($file,"LaunchActivity.java")==false){
			echo "LaunchActivity.java type 1 please";
			exit();
		}		
		$import = -1;
		$oncreate = -1;
        $start = false;
        $arr = array();
        $index = -1;
        $num=0;
        for($i=0;$i<count($array);$i++)
		{
            if(stristr($array[$i],'com.ganji.android.control;')!=false)
				$import = $i;
			if(stristr($array[$i],'void onCreate(')!=false)
            {
                $start = true;
                $index = $i;
            }
            if($start&&stristr($array[$i],"{")!==false){
                array_push($arr,"{");
                $num++;
                     echo $array[$i]."\r\n";
            }
            if($start&&stristr($array[$i],"}")!==false){
                array_pop($arr);
                $num--;
                echo $array[$i]."\r\n";
            }
            if( $start && $index!=$i && $num==0 && count($arr) == 0){
                $oncreate = $i;
                echo $array[$i]."退出\r\n";
                $oncreate--;
                break;
            }
            #if($start&&$index!=$i&&count($arr)==0){
            #    $oncreate = $i;
            #    echo $array[$i]."退出\r\n";
            #   #$oncreate--;
            #    break;
            #}
		}
        echo $oncreate."\r\n";
        if($import == -1 || $oncreate == -1){
			echo "未找到key type1";
			exit();
		}	
		$fp = fopen("LaunchActivity.java.bak", "w");//文件被清空后再写入 
		if($fp) 
		{ 
			$count=0; 
			for($i=0;$i<=count($array);$i++) 
			{ 
				if($i==$import){
					$flag=fwrite($fp,$array[$i]."\r\n"); 
					$flag=fwrite($fp,"import com.ganji.gatsdk.GatSDK;\r\n"); 
					if(!$flag) 
					{ 
						echo "写入文件失败<br>"; 
						break; 
					} 
				}
				else if($i==$oncreate){
					$flag=fwrite($fp,$array[$i]."\r\n"); 
					$flag=fwrite($fp,"GatSDK.activeCount();\r\n"); 
					if(!$flag) 
					{ 
						echo "写入文件失败<br>"; 
						break; 
					} 
				}else{
					$flag=fwrite($fp,$array[$i]."\r\n"); 
					if(!$flag) 
					{ 
						echo "写入文件失败<br>"; 
						break; 
					} 
				}
				
			} 
		} 
		else 
		{ 
			echo "打开文件失败"; 
		} 
		fclose($fp); 	
	}else if($type==2){
		if(stristr($file,"GJApplication.java")==false){
			echo "GJApplication.java type 2 please";
			exit();
		}		


		$import = -1;
		$oncreate = -1;
        $start = false;
        $arr = array();
        $index = -1;
        $num=0;
		

		for($i=0;$i<count($array);$i++)
		{
			if(stristr($array[$i],'com.ganji.android;')!=false)
				$import = $i;
			if(stristr($array[$i],'void onCreate(')!=false)
            {
                $start = true;
                $index = $i;
            }
            if($start&&stristr($array[$i],"{")!==false){
                array_push($arr,"{");
                $num++;
                     echo $array[$i]."\r\n";
            }
            if($start&&stristr($array[$i],"}")!==false){
                array_pop($arr);
                $num--;
                echo $array[$i]."\r\n";
            }
            if( $start && $index!=$i && $num==0 && count($arr) == 0){
                $oncreate = $i;
                echo $array[$i]."退出\r\n";
                $oncreate--;
                break;
            }
		}
		if($import == -1 || $oncreate == -1){
			echo "未找到key type 2";
			exit();
		}	
		echo $import;
		echo $oncreate;	
		$fp = fopen("GJApplication.java.bak", "w");//文件被清空后再写入 
		if($fp) 
		{ 
			$count=0; 
			for($i=0;$i<=count($array);$i++) 
			{ 
				if($i==$import){
					$flag=fwrite($fp,$array[$i]."\r\n"); 
					$flag=fwrite($fp,"import com.ganji.gatsdk.GatSDK;\r\n"); 
					$flag=fwrite($fp,"import com.ganji.gatsdk.GatSDKConfig;\r\n"); 
					if(!$flag) 
					{ 
						echo "写入文件失败<br>"; 
						break; 
					} 
				}
				else if($i==$oncreate){
					$flag=fwrite($fp,$array[$i]."\r\n"); 
					$flag=fwrite($fp,"GatSDK.init(getContext(),GatSDKConfig.APP_STORY);\r\n"); 
					if(!$flag) 
					{ 
						echo "写入文件失败<br>"; 
						break; 
					} 
				}else{
					$flag=fwrite($fp,$array[$i]."\r\n"); 
					if(!$flag) 
					{ 
						echo "写入文件失败<br>"; 
						break; 
					} 
				}
				
			} 
		} 
		else 
		{ 
			echo "打开文件失败"; 
		} 
		fclose($fp); 	
		
	}	
?>
