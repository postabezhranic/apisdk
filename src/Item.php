<?php

namespace Postabezhranic\Apisdk;

/**
 * @author Jan Matoušek
 * @version 1.0
 */
class Item
{	
	/** @var string @required*/
	private $kod;
	
	/** @var string|bool @required jmeno nebo spolecnost*/
	private $spolecnost;
	
	/** @var string|bool @required jmeno nebo spolecnost*/
	private $jmeno;
	
	/** @var string|bool */
	private $ulice;
	
	/** @var string|bool */
	private $email;
	
	/** @var string|bool @required u rumunska nemusí být*/
	private $psc;
	
	/** @var string|bool @required*/
	private $mesto;
	
	/** @var string|bool */
	private $dobirka;
	
	/** @var string|bool */
	private $pojisteni;
	
	/** @var string|bool */
	private $vs;
	
	/** @var string|bool */
	private $telefon;
	
	/** @var string|bool */
	private $prepravce;
	
	/** @var array|bool */
	private $sluzby;
	
	/** @var string|bool */
	private $ro_county;
	
	/** @var string|bool */
	private $nazev_odesilatele;
	
	/** @var string|bool */
	private $stat;
	
	/** @var string|bool */
	private $hmotnost;
	
	/** @var array|bool */
	private $produkty;

	/** @var string */
	private $id_lokality;

	/** @var string */
	private $prepravce_upresneni;

    /** @var bool */
    private $vytisknout_stitek_prepravce;

    /** @var bool */
    private $vytvorit_zpetny_stitek;

    /** @var string */
    private $referencni_kod;

    /** @var bool */
    private $vicekusova_zasilka;

	public function __construct($itemData){
		$this->kod = $itemData['kod'];
		$this->spolecnost = isset($itemData['spolecnost']) ? $itemData['spolecnost'] : FALSE;
		$this->jmeno = isset($itemData['jmeno']) ? $itemData['jmeno'] : FALSE;
		$this->ulice = isset($itemData['ulice']) ? $itemData['ulice'] : FALSE;
        $this->cp = isset($itemData['cp']) ? $itemData['cp'] : FALSE;
		$this->email = isset($itemData['email']) ? $itemData['email'] : FALSE;
		$this->psc = isset($itemData['psc']) ? $itemData['psc'] : FALSE;
		$this->mesto = isset($itemData['mesto']) ? $itemData['mesto'] : FALSE;
		$this->dobirka = isset($itemData['dobirka']) ? $itemData['dobirka'] : FALSE;
		$this->pojisteni = isset($itemData['pojisteni']) ? $itemData['pojisteni'] : FALSE;
		$this->vs = isset($itemData['vs']) ? $itemData['vs'] : FALSE;
		$this->telefon = isset($itemData['telefon']) ? $itemData['telefon'] : FALSE;
		$this->prepravce = isset($itemData['prepravce']) ? $itemData['prepravce'] : FALSE;
		$this->sluzby = isset($itemData['sluzby']) ? $itemData['sluzby'] : FALSE;
		$this->ro_county = isset($itemData['ro_county']) ? $itemData['ro_county'] : FALSE;
		$this->nazev_odesilatele = isset($itemData['nazev_odesilatele']) ? $itemData['nazev_odesilatele'] : FALSE;
		$this->stat = isset($itemData['stat']) ? $itemData['stat'] : FALSE;
		$this->hmotnost = isset($itemData['hmotnost']) ? $itemData['hmotnost'] : FALSE;
		$this->produkty = isset($itemData['produkty']) ? $itemData['produkty'] : FALSE;
		$this->id_lokality = isset($itemData['id_lokality']) ? $itemData['id_lokality'] : FALSE;
		$this->prepravce_upresneni = isset($itemData['prepravce_upresneni']) ? $itemData['prepravce_upresneni'] : FALSE;
        $this->vytisknout_stitek_prepravce = isset($itemData['vytisknout_stitek_prepravce']) ? $itemData['vytisknout_stitek_prepravce'] : FALSE;
        $this->vytvorit_zpetny_stitek = isset($itemData['vytvorit_zpetny_stitek']) ? $itemData['vytvorit_zpetny_stitek'] : FALSE;
        $this->referencni_kod = isset($itemData['referencni_kod']) ? $itemData['referencni_kod'] : FALSE;
        $this->vicekusove_zasilky = isset($itemData['vicekusove_zasilky']) ? $itemData['vicekusove_zasilky'] : FALSE;
        $this->vicekusova_zasilka = isset($itemData['vicekusova_zasilka']) ? $itemData['vicekusova_zasilka'] : FALSE;
	}
		
	public function getKod(){
		return $this->kod;
	}

	public function setKod($kod){
		$this->kod = $kod;
	}

	public function getSpolecnost(){
		return $this->spolecnost;
	}

	public function setSpolecnost($spolecnost){
		$this->spolecnost = $spolecnost;
	}

	public function getJmeno(){
		return $this->jmeno;
	}

	public function setJmeno($jmeno){
		$this->jmeno = $jmeno;
	}

	public function getUlice(){
		return $this->ulice;
	}

	public function setUlice($ulice){
		$this->ulice = $ulice;
	}

	public function getPsc(){
		return $this->psc;
	}

	public function setPsc($psc){
		$this->psc = $psc;
	}

	public function getMesto(){
		return $this->mesto;
	}

	public function setMesto($mesto){
		$this->mesto = $mesto;
	}

	public function getDobirka(){
		return $this->dobirka;
	}

	public function setDobirka($dobirka){
		$this->dobirka = $dobirka;
	}

	public function getPojisteni(){
		return $this->pojisteni;
	}

	public function setPojisteni($pojisteni){
		$this->pojisteni = $pojisteni;
	}

	public function getVs(){
		return $this->vs;
	}

	public function setVs($vs){
		$this->vs = $vs;
	}

	public function getTelefon(){
		return $this->telefon;
	}

	public function setTelefon($telefon){
		$this->telefon = $telefon;
	}

	public function getPrepravce(){
		return $this->prepravce;
	}

	public function setPrepravce($prepravce){
		$this->prepravce = $prepravce;
	}

	public function getSluzby(){
		return $this->sluzby;
	}

	public function setSluzby($sluzby){
		$this->sluzby = $sluzby;
	}

	public function getRo_county(){
		return $this->ro_county;
	}

	public function setRo_county($ro_county){
		$this->ro_county = $ro_county;
	}

	public function getNazev_odesilatele(){
		return $this->nazev_odesilatele;
	}

	public function setNazev_odesilatele($nazev_odesilatele){
		$this->nazev_odesilatele = $nazev_odesilatele;
	}

	public function getStat(){
		return $this->stat;
	}

	public function setStat($stat){
		$this->stat = $stat;
	}

	public function getHmotnost(){
		return $this->hmotnost;
	}

	public function setHmotnost($hmotnost){
		$this->hmotnost = $hmotnost;
	}

	public function getIdLokality()
	{
		return $this->id_lokality;
	}

	public function setIdLokality($id_lokality)
	{
		$this->id_lokality = $id_lokality;
	}

	/**
	 * @return string
	 */
	public function getPrepravceUpresneni()
	{
		return $this->prepravce_upresneni;
	}

	/**
	 * @param string $prepravce_upresneni
	 */
	public function setPrepravceUpresneni($prepravce_upresneni)
	{
		$this->prepravce_upresneni = $prepravce_upresneni;
	}

	/**
	 * @return array()
	 */
	public function getArray()
	{
		$array = array();
		$obj = new \ReflectionObject($this); 
		$namespace = $obj->getName(); 

		foreach((array) $this as $key => $data){
			$array[trim(strtolower(str_replace($namespace, '', $key)))] = $data;
		}
		
		return $array;
	}
}
