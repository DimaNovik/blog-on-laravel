<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClNotaryActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cl_notary_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });
    }


    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір відчуження нерухомого майна', '1');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір відчуження земельної ділянки', '2');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір відчуження транспортного засобу, іншої самохідної машини і механізму (крім договору міни на нерухоме майно)', '3');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Інший договір відчуження рухомого майна', '4');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір про приватизацію майна державних підприємств', '5');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір іпотеки', '6');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір застави', '7');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Шлюбний договір', '8');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір найму (оренди)', '9');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір позички', '10');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір управління нерухомим майном', '11');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір про зміну черговості одержання права на спадкування', '12');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Договір про зміну часток у спадщині', '13');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Інший договір', '14');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Заповіт', '15');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Відкриття спадкової справи', '16');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Вжиття заходів до охорони спадкового майна', '17');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Свідоцтво виконавцю заповіту', '18');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Свідоцтво про право на спадщину', '19');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Свідоцтво про право власності на частку в спільному майні подружжя у разі смерті одного з подружжя', '20');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Довіреність', '21');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Накладення заборони відчуження нерухомого майна та транспортного засобу', '22');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Зняття заборони відчуження нерухомого майна та транспортного засобу', '23');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Вірність копії (фотокопії) документу', '24');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Справжність підпису на документі', '25');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Вірність перекладу', '26');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Виконавчий напис ', '27');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Протест векселя ', '28');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Інша нотаріальна дія', '29');
    INSERT INTO cl_notary_actions (name, code) VALUES ('Надання додаткових  платних послуг без вчинення нотаріальної дії', '30');
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cl_notary_actions');
    }
}
