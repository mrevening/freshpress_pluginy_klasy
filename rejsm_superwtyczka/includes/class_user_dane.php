<?php

/**
 * Created by PhpStorm.
 * User: mrevening
 * Date: 2016-09-16
 * Time: 18:52
 */
class class_user_dane {
    private $user;
    public $nazwa_id;
    private $Nazwa;
    private $typ;
    private $wybory = array();
    private $metadata;
    private $show_hide = '';
    static private $lista_objektow = array();
    private function print_dropdown_list () { ?>
        <tr <?php echo $this->show_hide; ?>>
            <th scope="row"><?php echo $this->Nazwa ?></th>
            <td>
                <select id="<?php echo $this->nazwa_id ?>" class="drop-down" name="<?php echo 'key_'.$this->nazwa_id ?>">
                    <option disabled selected value></option>
                    <?php $i = 1; foreach ($this->wybory as $wybor) { ?>
                        <option value="<?php echo $i ?>"<?php selected($i, $this->metadata);?>><?php echo $wybor; $i++; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <?php
    }
    private function print_calendar () { ?>
        <tr>
            <th scope="row"><?php echo $this->Nazwa ?></th>
            <td>
                <input id="<?php echo $this->nazwa_id ?>" type="text" class="MyDate" name="key_<?php echo $this->nazwa_id ?>"
                       value="<?php echo $this->metadata; ?>"/>
            </td>
        </tr>
        <?php
    }
    public function __construct($user, $nazwa_id, $Nazwa, $typ, $wybory){

        $this->user = $user;
        $this->nazwa_id = $nazwa_id;
        $this->Nazwa = $Nazwa;
        $this->typ = $typ;
        $this->wybory = $wybory;
        $this->get_user_meta_method();
        array_push ( self::$lista_objektow, $this );
    }
    public function get_nazwa_id(){
        return $this->nazwa_id;
    }
    public function get_typ(){
            return $this->typ;
        }
    public function get_plec(){
        $pesel = $this->user->user_login;
        $plec = 0;
        if (substr($pesel, 9, 1) % 2 == 0) $plec = 1;
        else if (substr($pesel, 9, 1) % 2 == 1) $plec = 2;
        return $plec;
    }
    public function get_user_meta_method (){
        $this->metadata = get_user_meta($this->user->ID, $this->nazwa_id, true);
    }
    public static function get_lista_objektow () {
        return self::$lista_objektow;
    }
    public function update_metadata ( $userid ) {
        if( isset( $_POST['key_'.$this->nazwa_id] ) ) {
            $this->metadata = update_user_meta(  $userid , $this->nazwa_id, $_POST['key_'.$this->nazwa_id]);
        }
    }
    public function print_it () {

        switch ($this->typ){
            case 'calendar':
                $this->print_calendar();
                break;
            case 'calendar-zgon':
                if (!current_user_can('pacjent')) {
                    $this->print_calendar();
                }
                break;
            case 'drop-down-plec':
                $plec = $this->get_plec();
                ?>
                <tr>
                    <th scope="row"><?php echo $this->Nazwa ?></th>
                    <td>
                        <select id="<?php echo $this->nazwa_id ?>" name="<?php echo 'key_'.$this->nazwa_id ?>" disabled>
                                <?php
                                $i = 1;
                                foreach ($this->wybory as $wybor) {
                                    if ($plec == $i) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $wybor;  ?></option>
                            <?php   } 
                                $i++; 
                                }?>
                        </select>
                    </td>
                </tr>
                <?php
                break;
            case 'drop-down-dochod':
                $zatrudnienie = get_user_meta($this->user->ID, 'zatrudnienie', true);
                $this->show_hide = 'id="row-hide"';
                if ($zatrudnienie != "2")   $this->show_hide .= ' style="display:none"';
                else $this->show_hide = 'id="row-hide"';
                $this->print_dropdown_list();
                break;
            case 'drop-down':
                $this->print_dropdown_list();
                break;
        }


    }
    public static function reset_lista_objektow(){
        self::$lista_objektow = array();
    }
}
