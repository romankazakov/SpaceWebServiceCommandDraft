<?php
interface ServiceCommand  {
	function runMeTender();
}

class Server {
	const SWIX = 0;
	const VH = 1;
	const COLO = 2;
	const VDS = 3;
}

class ServiceCommandDump implements ServiceCommand {
	function runMeTender(){

	}
}

class ServiceCommandVh_Swix implements ServiceCommand {

	function runMeTender(){
		echo __CLASS__;
	}
}

class ServiceCommandSwix_Vh implements ServiceCommand {

	function runMeTender(){
		echo __CLASS__;
	}
}

class ServiceCommandColo_Vds implements ServiceCommand {

	function runMeTender(){
		echo __CLASS__;
	}
}

class ServiceCommandVds_Colo implements ServiceCommand {

	function runMeTender(){
		echo __CLASS__;
	}
}


class ServiceCommandProcessor {

	function setUpCommands($s, $d , $service){
		$allCmds[ Server::SWIX ][ Server::VH ] = new ServiceCommandVh_Swix( $s, $d, $service  );
		$allCmds[ Server::VH   ][ Server::SWIX ] = new ServiceCommandVh_Swix( $s, $d, $service  );
		$allCmds[ Server::COLO ][ Server::VDS ] = new ServiceCommandVh_Swix( $s, $d, $service  );
		$allCmds[ Server::VDS  ][ Server::COLO ] = new ServiceCommandVh_Swix( $s, $d, $service  );
	}

	function commandInvoke( $s, $d , $service ) {
		$this->setUpCommands($s, $d , $service);

		if ( isset( $cmds[ $s->getType() ][ $d->getType() ] ) ) {
			$cmd = $cmds[ $s->getType() ][ $d->getType() ];
			$cmd->runMeTender();
		} else {
			throw new Exception( 'No command for servers.' );
		}
	}

	function run($srcServerId, $dstServerId , $customerId){
		try {
			$this->commandInvoke( new Server($srcServerId), new Server($dstServerId), new Service_Vh($customerId) );
		} catch (Exception $exp){
			die('Error during running command '.$exp->getMessage() );
		}
	}
}








