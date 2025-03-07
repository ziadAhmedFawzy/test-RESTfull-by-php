<?php 

function Auth($cookies) {
    if($cookies === "JohnDoe") {
        return true;
    }
    else {
        return false;
    }
}