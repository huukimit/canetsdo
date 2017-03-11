<?php


namespace App\Libraries\S2Cms;
use DB;

class BackupDB{

    static function backup_sql($dir_backup = ''){
        $backupDatabase = new Backup_Database(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));
        $get_backup = $backupDatabase->backupTables('*', $dir_backup);

        if($get_backup){
            return $dir_backup.$get_backup;
        }else{
            return false;
        }
    }
}



// SAO LUU CSDL
class Backup_Database {
    var $host = '';
    var $username = '';
    var $passwd = '';
    var $dbName = '';
    var $charset = '';
    // Config
    function __construct($host, $username, $passwd, $dbName, $charset = 'utf8'){
        $this->host     = $host;
        $this->username = $username;
        $this->passwd   = $passwd;
        $this->dbName   = $dbName;
        $this->charset  = $charset;
        $this->initializeDatabase();
    }
    protected function initializeDatabase(){
        $conn = @mysql_connect($this->host, $this->username, $this->passwd);
        @mysql_select_db($this->dbName, $conn);
        if (! @mysql_set_charset ($this->charset, $conn)){
            @mysql_query('SET NAMES '.$this->charset);
        }
    }

    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     */
    public function backupTables($tables = '*', $outputDir = '.' , $web_path_backup = ''){
        try{
            $str = '';
            /**
            * Tables to export
            */
            if($tables == '*'){
                $tables = array();
                $result = @mysql_query('SHOW TABLES');
                while($row = @mysql_fetch_row($result)){
                    $tables[] = $row[0];
                }
            }else{
                $tables = is_array($tables) ? $tables : explode(',',$tables);
            }

            $sql = '';
            $sql .= "-- Backup SQL Version ".config('manager.version.code')."\n";
            $sql .= "-- Created by Pham Dinh Cuong - Skype: PhamCuongT2 - Phone: 0986.835.651\n";
            $sql .= "-- Server: ".$_SERVER["HTTP_HOST"]."\n";
            $sql .= "-- Host: ".$this->host."\n";
            $sql .= "-- Database: ".$this->dbName."\n";
            $sql .= "-- Generation Time: ".date("H:i:s d-m-Y",time())."\n";
            $sql .= "-- PHP Version: ".phpversion()."\n";
            $sql.="\n-- ------------------------------------------------------------------------------------------------\n\n\n";
            $sql .= "-- Created database if not exists\n";
            $sql .= '-- CREATE DATABASE IF NOT EXISTS '.$this->dbName.";\n";
            $sql .= '-- USE '.$this->dbName.";";
            $sql.="\n-- ------------------------------------------------------------------------------------------------\n\n\n";
            /**
            * Iterate tables
            */
            foreach($tables as $table){
                $str .= "Backing up ".$table." table...";

                $result = @mysql_query('SELECT * FROM '.$table);
                $numFields = @mysql_num_fields($result);
                $sql .= "-- Created table `".$table."` if not exists\n";
                $sql .= 'DROP TABLE IF EXISTS '.$table.';';
                $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
                $sql.= "\n\n".$row2[1].";\n\n";

                $sql .= "-- Import SQL to `".$table."`\n";
                for ($i = 0; $i < $numFields; $i++){
                    while($row = mysql_fetch_row($result)){
                        $sql .= 'INSERT INTO '.$table.' VALUES(';
                        for($j=0; $j<$numFields; $j++){
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n","\\n",$row[$j]);
                            if (isset($row[$j])){
                                $sql .= '"'.$row[$j].'"' ;
                            }else{
                                $sql.= '""';
                            }

                            if ($j < ($numFields-1)){
                                $sql .= ',';
                            }
                        }

                        $sql.= ");\n";
                    }
                }
                $sql.="\n-- ------------------------------------------------------------------------------------------------\n\n\n";

                $str .= " OK" . "<br />";
            }
        }
        catch (Exception $e){
            var_dump($e->getMessage());
            return false;
        }

        return $this->saveFile($sql, $outputDir);
    }

    /**
     * Save SQL to file
     * @param string $sql
     */
    protected function saveFile(&$sql, $outputDir = '.'){
        if (!$sql) return false;
        try{
            $file_sql = 'database-backup-'.$this->dbName.'-'.date("Ymd-His", time()).'-'.rand(time() , 2*time()).'.sql';
            $handle = fopen($outputDir.$file_sql,'w+');
            fwrite($handle, $sql);
            fclose($handle);
        }
        catch (Exception $e){
            var_dump($e->getMessage());
            return false;
        }

        return $file_sql;
    }
}