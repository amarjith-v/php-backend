<?php
  
namespace App\Enums;
 
enum OrderStatusEnum:string {
    case Pending = 'pending';
    case Selected = 'selected';
    case Picked = 'picked';
    case Delivery = 'delivered';
}