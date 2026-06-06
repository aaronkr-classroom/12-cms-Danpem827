<?php
function pdo(PDO $pdo,string $sql,array $argument = null){
    if(!$argument){
        return $pdo->query($sql);
    }
    $statement =$pdo->prepare($sql);
    $statement->execute($argument);
    return $statement;
}


function html_escape($text): string{
    return htmlspecialchars($text,ENT_QUOTES,'UTF-8',false);
}
function format_date(string $string): string{
    $date =date_create_from_format('Y;m;d H:i:s',$string);
    return $date->format('F d,Y');
}


set_error_handler('handle_error');
function header_error($error_type,$error_message,$error_file,$error_line){
    throw ne ErrorException($error_message,0,$error_type,$error_file,$error_line);
}


set_exception_handler('handle_exception');
function header_exception($e){
    error_log($e);
    http_response_code(500);
    echo "<h1>Error 500</h1>
          <h2>Sorry, a problem occurred.</h2>
          <p>The site's owners have been informed.Please try again later.</p>";
}

register_shutdown_function('handle_shutdown');
function handle_shutdown(){
    $error = error_get_last();
    if($error !== null){
        $e =  new ErrorException($error['message'],0,$error['type'],$error['file'],$error['line']);
        header_exception($e);
    }
}