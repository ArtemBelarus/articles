<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Ean;
use App\Models\OriginalCode;
use App\Models\RelatedNumber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SeedTestData extends Seeder
{
    const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  ---...';
    const CHARS_LENGTH = 70;
    const DATA_ITEM_LEGNTH = 16;

    const ARTICLES_TO_INSERT = 10000000;
    const CODES_PREPARED_TOTAL = 2000000;

    const MAX_ORIGINAL_CODES_PER_ARTICLE = 4;
    const MAX_RELATED_NUMBERS_ARTICLE = 2;
    const MAX_EANS_PER_ARTICLE = 1;

    // regenerated test data files:
    // storage/app/tmp/tmp_articles.csv | tmp_original_codes.csv | tmp_related_number.csv | tmp_eans.csv
    const GENERATE_NEW_FILES = false;

    /**
     * @throws \Exception
     */
    public function run()
    {
        DB::disableQueryLog();
        DB::statement('SET GLOBAL innodb_buffer_pool_size = 1024*1024*512;');
        DB::statement('SET sql_log_bin = 0;');
        DB::statement('SET GLOBAL local_infile = 1;');
        DB::statement('SET UNIQUE_CHECKS = 0;');
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        Article::query()->truncate();
        OriginalCode::query()->truncate();
        RelatedNumber::query()->truncate();
        Ean::query()->truncate();

        Storage::disk('local')->makeDirectory('tmp');
        $startTime = microtime(true);

        // articles
        $this->command->info('========= Articles =========');
        $this->insertArticles($startTime);
        $this->command->info('====== Done. Total time = ' . $this->getTime($startTime) . 's.' . "\n");

        // codes data
        $this->command->info('====== Preparing codes data .... ');
        $codesPreparedData = $this->prepareCodesData();
        $this->command->info('====== Codes data prepared, total time = ' . $this->getTime($startTime) . 's.' . "\n");

        // original codes
        $this->command->info('========= Original codes =========');
        $this->insertCodesIntoTable($codesPreparedData, 'original_codes', self::MAX_ORIGINAL_CODES_PER_ARTICLE, $startTime);
        $this->command->info('====== Done. Total time = ' . $this->getTime($startTime) . 's.' . "\n");

        // related numbers
        $this->command->info('========= Related number =========');
        $this->insertCodesIntoTable($codesPreparedData, 'related_numbers', self::MAX_RELATED_NUMBERS_ARTICLE, $startTime);
        $this->command->info('====== Done. Total time = ' . $this->getTime($startTime) . 's.' . "\n");

        // eans
        $this->command->info('========= Eans =========');
        $this->insertCodesIntoTable($codesPreparedData, 'eans', self::MAX_EANS_PER_ARTICLE, $startTime);
        $this->command->info('====== Done. Total time = ' . $this->getTime($startTime) . 's.' . "\n");
        $this->command->info('========= Insert test data finished =========');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @return string
     */
    private function randomString(): string
    {
        $randomString = '';
        for ($i = 0; $i < self::DATA_ITEM_LEGNTH; $i++) {
            $randomString .= self::CHARS[rand(0, self::CHARS_LENGTH - 1)];
        }
        return $randomString;
    }

    /**
     * @return array
     */
    private function prepareCodesData(): array
    {
        $data = [];
        for ($i = 0; $i < self::CODES_PREPARED_TOTAL; $i += 1) {
            $value = $this->randomString();
            $data[] = $value;
        }
        return $data;
    }

    /**
     * @param array $codesPreparedData
     * @param string $table
     * @param int $maxItems
     * @param float $startTime
     * @throws \Exception
     */
    private function insertCodesIntoTable(array &$codesPreparedData, string $table, int $maxItems, float $startTime)
    {
        $isFileExists = Storage::disk('local')->exists('tmp/tmp_' . $table . '.csv');

        if (!$isFileExists || self::GENERATE_NEW_FILES) {
            $this->command->info('=== Generating new test data file ...');

            $file = fopen('storage/app/tmp/tmp_' . $table . '.csv', 'w');

            for ($i = 1; $i <= self::ARTICLES_TO_INSERT; $i++) {
                $addCodesTotal = random_int(0, $maxItems);
                for ($k = 0; $k < $addCodesTotal; $k++) {
                    fwrite($file,
                        $i . ',' . $codesPreparedData[random_int(0, self::CODES_PREPARED_TOTAL - 1)] . PHP_EOL);
                }
            }

            fclose($file);

            $this->command->info('=== Test data file created (total time = ' . $this->getTime($startTime) . 's.), loading it to DB.');
        } else {
            $this->command->info('=== Test data file found, loading it to DB. ');
        }

        DB::statement("
            LOAD DATA LOCAL INFILE
            '" . storage_path('app/tmp/tmp_' . $table . '.csv') . "' 
            INTO TABLE " . $table . "
            FIELDS TERMINATED BY ','
            (article_id, value, value_search)
            SET `value_search` = REPLACE(REPLACE(REPLACE(value, '-', ''), '.', ''), ' ', '')
        ;");
    }

    /**
     * @param float $startTime
     */
    private function insertArticles(float $startTime)
    {
        $isFileExists = Storage::disk('local')->exists('tmp/tmp_articles.csv');

        if (!$isFileExists || self::GENERATE_NEW_FILES) {
            $this->command->info('=== Generating new test data file ...');

            $file = fopen('storage/app/tmp/tmp_articles.csv', 'w');

            for ($i = 0; $i < self::ARTICLES_TO_INSERT; $i++) {
                $number = $this->randomString();
                fwrite($file, $number . PHP_EOL);
            }

            fclose($file);

            $this->command->info('=== Test data file created (total time = ' . $this->getTime($startTime) . 's.), loading it to DB.');
        } else {
            $this->command->info('=== Test data file found, loading it to DB. ');
        }

        DB::statement("
            LOAD DATA LOCAL INFILE
            '" . storage_path('app/tmp/tmp_articles.csv') . "' 
            INTO TABLE articles
            FIELDS TERMINATED BY ','
            (number, number_search)
            SET `number_search` = REPLACE(REPLACE(REPLACE(number, '-', ''), '.', ''), ' ', '')
        ;");
    }

    /**
     * @param $startTime
     * @return string
     */
    private function getTime($startTime): string
    {
        return number_format(microtime(true) - $startTime, 2, '.', '');
    }
}
