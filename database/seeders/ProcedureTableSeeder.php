<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProcedureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('procedures')->count();
        if($count == 0) {
            DB::table('procedures')->insert([
                ['title' => 'Danties gydymas Biodentin medžiaga', 'price' => '40', 'details' => 'Biodentin - biologiškai aktyvus dentino pakaitalas. Ši medžiaga padeda ilgiau išlaikyti dantų gyvybingumą. Gydant Biodentinu atitolinamas endodontinis dantų gydymas ar jo išvengiama iš vis. Biodentiną sudaro išgryninti mineralų komponentai, savo sudėtyje neturintys monomerų.'],
                ['title' => 'Retinuoto danties šalinimas', 'price' => '99', 'details' => 'Prieš traukiant protinius dantis, atliekami rentgenologiniai tyrimai. Šių tyrimų dėka galima tiksliai nustatyti danties ir aplinkinių struktūrų būklę bei šaknų padėtį. Protinių dantų šalinimas dažniausiai yra atliekamas nuskausminus vietine nejautra.'],
                ['title' => 'Išdygusio protinio danties šalnimas', 'price' => '89', 'details' => 'Protinių dantų rovimas – chirurginė, protinių dantų šalinimo, procedūra. Dažnai, dėl vietos stokos žandikaulio lanke, protiniai dantys pradeda dygti šonu, atsirėmę į kitus dantis, o pritrūkus vietos, stumia greta esančius, anksčiau išdygusius dantis.' ],
                ['title' => 'Endodontinis gydymas', 'price' => '80', 'details' => 'Endodontinio gydymo metu, pašalinamas pažeistas danties nervas (pulpa), tuomet kanalas apdorojamas specialiais instrumentais bei cheminėmis medžiagomis ir užplombuojamas. Endodontinis gydymas apsaugo, kad mikroorganizmai neplistų dantyje ir už danties ribų. Paprastai endodontinio gydymo metu naudojamas mikroskopas bei atliekamos rentgeno nuotraukos. Mikroskopas pagerina matomumą (padidina ir apšviečia vaizdą) bei užtikrina greitesnį, tikslesnį gydymą' ],
                ['title' => 'Profesionali burnos higiena', 'price' => '50', 'details' => 'Profesionalios burnos ertmės higienos metu naudojama speciali įranga, leidžianti pašalinti apnašas. Minkštosios apnašos šalinamos naudojant šepetėlius, kurių galvutės sukasi ratu ir taip nuvalo net ir sunkiai pasiekiamas vietas. Kietieji akmenys šalinami ultragarso aparatu arba kitais specialiais įrankiais, kurie taip pat gali padėti pasiekti sunkiai dantų šepetuku pasiekiamas vietas. Kai dantys nuvalomi, jie nupoliruojami, o burnos ertmėje jaučiamas šviežumas.' ],
                ['title' => 'Danties plombavimas', 'price' => '30', 'details' => 'Danties plombavimas – tai įvairių defektų pašalinimas, ertmes užpildant kompozitinėmis medžiagomis. Atliekant šią procedūrą taikoma vietinė nejautra, pašalinami karieso paveikti apirę audiniai, ant dantų sienelių tepama speciali rūgštis, plaunamos danties sienelės, sluoksniais dedama plomba, atkuriama danties struktūra. Kiekvienas sluoksnis sukietinamas specialia lempa. Užbaigus danties plombavimo procedūrą, atkuriamas danties paviršius, tarpdančiai, plomba šlifuojama iki kol sąkandis nekliūva.' ]
            ]);
        }
        else {
            //data already there no need to add data
        }
    }
}
