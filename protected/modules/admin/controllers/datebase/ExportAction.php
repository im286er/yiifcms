<?php
/**
 *  导出
 * 
 * @author  Sim Zhao <326196998@qq.com>
 * @link    http://www.yiifcms.com/
 * @copyright   Copyright (c) 2014-2015. All rights reserved.
 */

class ExportAction extends CAction
{	
	public function run(){
        if(Yii::app()->request->isPostRequest) {            
            $this->export();
        } else {
            $this->controller->render('export');        
        }
	}
    
    /**
     * 导出数据
     */
    public function export ()
    {        
        $sizelimit = Yii::app()->request->getParam('sizelimit');
        $tables = Yii::app()->db->schema->tableNames;
        $backup_prefix = 'db_'.date('YmdHis').'_';
        if(!is_dir($this->controller->backup)){
            mkdir($this->controller->backup,0777,true);
        }
        $size =  $sizelimit * 1024;        
        self::exportDatabase($tables, $size, $backup_prefix);        
    }

    /**
     * 数据备份
     * 
     * @param  $tables   所有表
     * @param  $sizelimit 分卷大小
     */
    private function exportDatabase ($tables, $sizelimit, $backup_prefix = '')
    {
        ini_set('max_execution_time', '3600');
        Yii::app()->db->createCommand('SET NAMES utf8')->execute();
        $ext = '.sql'; 
        $part = 1;
        //写入注释说明
        $tabledump = "--comment_start"
            . "\n-- 数据库备份文件"
            . "\n-- 作者:      Sim Zhao <326196998@qq.com>"
            . "\n-- 时间：     ".date('Y-m-d H:i:s')
            . "\n-- Mysql版本：".mysql_get_server_info ()
            . "\n-- PHP版本：  ".  phpversion()
            . "\n-- 程序版本： ".$this->controller->_cmsVersion   
            . "\n--comment_end ";
        $tabledump .= "\n".$this->controller->cutline;
        $backfile = $this->controller->backup. '/' . $backup_prefix.$part.$ext;
        file_put_contents($backfile, $tabledump, FILE_APPEND );
        echo "<style>"
                . "body{ "
                . "font-family:Monaco, DejaVu Sans Mono, Bitstream Vera Sans Mono, Consolas, Courier New, monospace; "
                . "font-size:14px; "
                . "line-height:1.8em; "
                . "background-color:#000000; "
                . "padding:20px;"
                . "color:#FFFFFF;}"
                . "</style>";
        echo "---------------备份开始[start]------------";
        for ($i = 0; $i < count($tables); $i++) {
            $table_name = $tables[$i];
            echo "<br/>正在备份数据表：".$table_name."...";            
            //先导出表结构
            $tabledump = "\n\nDROP TABLE IF EXISTS `$table_name`;\n".$this->controller->cutline."\n";
            $res = Yii::app()->db->createCommand("SHOW CREATE TABLE `{$table_name}` ")->queryRow();            
            $tabledump .= $res['Create Table'] . ";\n\n".$this->controller->cutline."\n";
            
            //取出数据
            $all = Yii::app()->db->createCommand("SELECT count(*) as count FROM `{$table_name}`")->queryRow();
            $count = $all ? $all['count'] : 0;            
            $offset = 100;
            $page_count = ceil($count/$offset);
            $page = 0;
            while($page <= $page_count) {
                $start = $page * $offset;
                $tabledump .= self::_getDataFromTable($table_name, $start, $offset);                
                $backfile = $this->controller->backup. '/' . $backup_prefix.$part.$ext;
                file_put_contents($backfile, $tabledump, FILE_APPEND );
                //清除结果缓存 得到真正的文件大小
                clearstatcache(true, $backfile);                
                if(filesize($backfile) >= $sizelimit) {
                    $part++;
                    $tabledump = '';
                }
                $page++;
            }
            ob_flush();
            flush();
            echo "<label style='color:green'>完成</label>";
            usleep(10000);                        
        }
        echo "<br/>---------------备份完成[success]------------";
    }
    
    /**
     * 从表中查询数据 并返回插入语句
     * 
     * @param type $table_name
     * @param type $start
     * @param type $offset
     * @return string
     */
    private function _getDataFromTable($table_name= '', $start = 0, $offset = 100)
    {       
        $str = '';
        $res = Yii::app()->db->createCommand("SELECT * FROM `{$table_name}` LIMIT {$start} , {$offset}")->queryAll();    
        if($res) {
            foreach($res as $row) {
                $str .= "INSERT INTO `{$table_name}` SET ";
                $fileds = '';
                foreach($row as $field => $value) {
                    $value = mysql_escape_string($value);
                    $fileds .= "`{$field}` = '{$value}' ,";
                }
                $fileds = rtrim($fileds,',').";\n".$this->controller->cutline."\n";
                $str .= $fileds;
            }
        }
        return $str;        
    }

}