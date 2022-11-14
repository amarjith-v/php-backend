<?php
  
namespace App\Enums;
 
enum ProductStatusEnum:string {
    case Pending = 'pending';
    case Selected = 'selected';
    case Picked = 'picked';
    case Delivery = 'delivery';
}