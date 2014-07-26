<?php
	// WebDSS OS.php Copyright 2011 Timothy Middelkoop, license GPL 2.0 or greater.
	namespace WebDSS;
	
	/**
	 * WebDSS\OS Class for OSSolverService
	 * Provides a wrapper for OSiL and OSSolverService
	 * @author Timothy Middelkoop, Ph.D.
	 * @copyright 2011 Timothy Middelkoop
	 * @license Apache License 2.0
	 *
	 */
	class OS{
	        const INFO=FALSE;
	        const DEBUG=FALSE;
	        const TRACE=FALSE; // Keep generated files
	        private $path="\\WebDSS\\workspace\\OSSolverService ";  // Location and name of Executable + 1 space.
	       
	        private $osil; // OSiL in SimpleXMLElement
	        private $osrl; // OSrL in SimpleXMLElement
	        private $var=array(); // Reverse IDX mapping ($idx->$name).
	       
	        function __construct($maxOrMin='min'){
	                $this->osil=new \SimpleXMLElement($this->template);
	                $this->osil->instanceData->objectives->obj['maxOrMin']=$maxOrMin;
	                $this->osil->instanceHeader->name=php_uname('n').' '.date('c');
	        }
	       
	        function solve(){
	                $osil=\tempnam('.','OS-');
	                $osrl=\tempnam('.','OS-');
	                if(self::INFO) print "OS.solve> $osil\n";
	                if(self::DEBUG) print_r($this->osil->asXML());
	                $this->osil->asXML($osil) or die("OSiL $osil write failed");
	                $cmd="-osil $osil -osrl $osrl";
	                exec($this->path.$cmd,$output,$result);
	                if($result!=0) die($this->path . "exec failed: $result $cmd \n" . implode("\n",$output));
	                $xml=file_get_contents($osrl) or die("OSrL $osrl read failed");
	                $xml=preg_replace('/"os.optimizationservices.org"/','"uri:os.optimizationservices.org"',$xml);
	                $this->osrl=new \SimpleXMLElement($xml);
	                if(self::DEBUG) print_r($this->osrl->asXML());
	                if(self::INFO) print "OS.solve> solution ".$this->osrl->general->instanceName."\n";
	                if(self::TRACE==False){
	                        unlink($osil);
	                        unlink($osrl);
	                }
	        }
	       
	        function getSolution(){
	                $solution=$this->osrl->optimization->solution;
	                if(self::DEBUG) print "obj: ".(real)$solution->objectives->values->obj."\n";
	                return (real)$solution->objectives->values->obj;
	        }
	       
	        function getVariables(){
	                $value=array();
	                $solution=$this->osrl->optimization->solution;
	                $variables=$this->osil->instanceData->variables;
	                foreach($solution->variables->values->var as $var){
	                        $value[(string)$variables->var[(integer)$var['idx']]['name']]=(float)$var;
	                        if(self::DEBUG) print $var['idx'].": ";
	                        if(self::DEBUG) print (float)$var."\n";
	                }
	                return $value;
	        }
	       
	        function addVariable($name,$type=null){
	                $variables=$this->osil->instanceData->variables; // shortcut
	                $this->var[$name]=$variables->var->count(); // $name to $idx (zero based -- preinsert)
	                $var=$variables->addChild('var');
	                $var['name']=$name;  // assign name attribute to var tag
	                if(isset($type)) $var['type']=$type;
	                $variables['numberOfVariables']=$variables->var->count(); // update variables tag
	        }
	       
	        function addObjCoef($name,$value){
	                $idx=$this->var[$name]; // find $idx from variable $name
	                $obj=$this->osil->instanceData->objectives->obj;
	                $coef=$obj->addChild('coef',$value);
	                $coef['idx']=$idx;
	                $obj['numberOfObjCoef']=$obj->coef->count();
	        }
	       
	        function addConstraint($ub=null,$lb=null){
	                $constraints=$this->osil->instanceData->constraints;
	                $con=$constraints->addChild('con');
	                if(isset($lb)) $con['lb']=$lb;
	                if(isset($ub)) $con['ub']=$ub;
	                $constraints['numberOfConstraints']=$constraints->con->count();
	        }
	
	        function endConstraint($ub=null,$lb=null){
	                $con=$this->osil->instanceData->constraints->con[-1];
	                if(isset($lb)) $con['lb']=$lb;
	                if(isset($ub)) $con['ub']=$ub;
	                $lcc=$this->osil->instanceData->linearConstraintCoefficients;
	                $lcc->start->addChild('el',$lcc->value->el->count());
	        }
	       
	        function addConstraintCoef($name,$value){
	                $lcc=$this->osil->instanceData->linearConstraintCoefficients;
	                $lcc->colIdx->addChild('el',$this->var[$name]);
	                $lcc->value->addChild('el',$value);
	                $lcc['numberOfValues']=$lcc->value->el->count();
	        }
	       
	        private $template=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<osil xmlns="uri:os.optimizationservices.org"
	      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	      xsi:schemaLocation="uri:os.optimizationservices.org http://www.optimizationservices.org/schemas/OSiL.xsd">
	   <instanceHeader>
	      <name/>
	      <source>PHP</source>
	      <description>.</description>
	   </instanceHeader>
	   <instanceData>
	      <variables numberOfVariables="0"/>
	      <objectives>
	         <obj maxOrMin="min" numberOfObjCoef="0"/>
	      </objectives>
	      <constraints numberOfConstraints="0"/>
	      <linearConstraintCoefficients numberOfValues="0">
	         <start><el>0</el></start>
	         <colIdx/>
	         <value/>
	      </linearConstraintCoefficients>
	   </instanceData>
	</osil>
XML;
}
?>