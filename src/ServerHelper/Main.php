<?php

namespace ServerHelper;

/*
 *  ___                      _  _     _               
 * / __| ___ _ ___ _____ _ _| || |___| |_ __  ___ _ _ 
 * \__ \/ -_) '_\ V / -_) '_| __ / -_) | '_ \/ -_) '_|
 * |___/\___|_|  \_/\___|_| |_||_\___|_| .__/\___|_|  
 *                                     |_|            
 * ServerHelper by MeltIce QQ:3480656548
 * 倒卖本插件死全家
 *
 */
 
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener{
  public function onEnable(){
    $this->saveDefaultConfig();
	@mkdir($this->getDataFolder(),0777,true);
	$this->config=new Config($this->getDataFolder()."config.yml",Config::YAML,array(
	"OnlineTip"=>"ON",
	"GiveBread"=>"ON",
    "BreadNum"=>16,
    "ServerHelp"=>"ON",
	"PlayerMessP1"=>"§a==服务器帮助(1/5)==\n§a待修改",
	"PlayerMessP2"=>"§a==服务器帮助(2/5)==\n§a待修改",
	"PlayerMessP3"=>"§a==服务器帮助(3/5)==\n§a待修改",
	"PlayerMessP4"=>"§a==服务器帮助(4/5)==\n§a待修改",
	"PlayerMessP5"=>"§a==服务器帮助(5/5)==\n§a待修改"
	));
    $this->getServer()->getPluginManager()->registerEvents($this,$this);
    $this->getLogger()->info("§b=======================");
    $this->getLogger()->info("§a✔ServerHelper成功启用");
    $this->getLogger()->info("§e作者:MeltIce  QQ:3480656548");
    $this->getLogger()->info("§6访问我们的Github页面:https://github.com/Meltide/ServerHelper");
    $this->getLogger()->info("§c倒卖插件死全家");
    $this->getLogger()->info("§b=======================");
  }
  public function onDisable(){
    $this->getLogger()->info(TextFormat::RED."✘ServerHelper已关闭");
  }
  public function onJoin(PlayerJoinEvent $event){
    $tip = $this->getConfig()->get("OnlineTip");
    if($tip == "ON"){
      $online = count($this->getServer()->getOnlinePlayers());
      $this->getServer()->broadcastMessage("§6当前服务器人数: $online");
    }
  }
  public function onQuit(PlayerQuitEvent $event){
    $tip = $this->getConfig()->get("OnlineTip");
    if($tip == "ON"){
      $online = count($this->getServer()->getOnlinePlayers());
      $this->getServer()->broadcastMessage("§6当前服务器人数: $online");
    }
  }
  public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
    if($cmd->getName() == "sh"){
      $playerm = $this->getConfig()->get("ServerHelp");
      if($playerm == "ON"){
        if(!isset($args[0]) or (is_int($args[0]) and $args[0] > 0)){
          return false;
        }

        $playerm1 = $this->getConfig()->get("PlayerMessP1");
        $playerm2 = $this->getConfig()->get("PlayerMessP2");
        $playerm3 = $this->getConfig()->get("PlayerMessP3");
        $playerm4 = $this->getConfig()->get("PlayerMessP4");
        $playerm5 = $this->getConfig()->get("PlayerMessP5");

        switch($args[0]){
          case "1":
            $sender->sendMessage($playerm1);
            break;
          case "2":
            $sender->sendMessage($playerm2);
            break;
          case "3":
            $sender->sendMessage($playerm3);
            break;
          case "4":
            $sender->sendMessage($playerm4);
            break;
          case "5":
            $sender->sendMessage($playerm5);
            break;
          default:
            return false;
        }
      }else{
        $sender->sendMessage(TextFormat::RED."服主未开启服务器帮助功能");
      }

    }elseif($cmd->getName() == "shm"){
      if(!isset($args[0]) or (is_int($args[0]) and $args[0] > 0)){
        return false;
      }
      switch($args[0]){
        case "reload":
          $this->reloadConfig();
          $sender->sendMessage(TextFormat::GREEN."重载配置文件完成");
          break;
        case "version":
          $sender->sendMessage("§bServerHelper 插件版本:1.2.0");
          $sender->sendMessage("§b作者:MeltIce  QQ:3480656548");
          $sender->sendMessage(TextFormat::RED."倒卖本插件死全家");
          break;
        default:
          return false;
      }

    }elseif($cmd->getName() == "bread") {
      $bread = $this->getConfig()->get("GiveBread");
      if($bread == "ON"){
        if(!$sender instanceof Player){
          $sender->sendMessage(TextFormat::RED . "这个命令只适用于玩家！请在游戏中执行这个命令！");
        }else{
          $bnum = $this->getConfig()->get("BreadNum");
          $sender->getPlayer()->getInventory()->addItem(new Item(297, 0, $bnum));
          $sender->sendMessage(TextFormat::YELLOW . "你获得了" . $bnum . "个面包");
        }
      }else{
        $sender->sendMessage(TextFormat::RED . "服主未开启获得面包功能");
      }
    }
    return true;
  }
}
