<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddBeforeInsertTriggerUpdateTeamsToGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER update_teams_before_insert
            BEFORE INSERT ON games
            FOR EACH ROW
            BEGIN
                DECLARE team_a_name VARCHAR(255);
                DECLARE team_b_name VARCHAR(255);
                DECLARE team_a_abb VARCHAR(255);
                DECLARE team_b_abb VARCHAR(255);

                -- Get the team names based on the team ids
                SELECT name, abb INTO team_a_name, team_a_abb
                FROM teams
                WHERE id = NEW.team_a_id
                LIMIT 1;

                SELECT name, abb INTO team_b_name, team_b_abb
                FROM teams
                WHERE id = NEW.team_b_id
                LIMIT 1;

                -- Set the team names before inserting into the games table
                SET NEW.team_a = team_a_name;
                SET NEW.team_b = team_b_name;
                SET NEW.team_a_abb = team_a_abb;
                SET NEW.team_b_abb = team_b_abb;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_teams_before_insert');
    }
}
