<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Artisan;
use App\Upload;
use App\Product;
use App\Tax;
use App\ProductTax;
use ZipArchive;

class UpdateController extends Controller
{
    public function step0(Request $request) {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('This action is disabled in demo mode'))->error();
            return back();
        }
        if ($request->has('update_zip')) {
            if (class_exists('ZipArchive')) {
                // Create update directory.
                $dir = 'updates';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $path = Upload::findOrFail($request->update_zip)->file_name;

                //Unzip uploaded update file and remove zip file.
                $zip = new ZipArchive;
                $res = $zip->open(base_path('public/' . $path));

                if ($res === true) {
                    $res = $zip->extractTo(base_path());
                    $zip->close();
                } else {
                    flash(translate('Could not open the updates zip file.'))->error();
                    return back();
                }

                return redirect()->route('update.step1');
            }
            else {
                flash(translate('Please enable ZipArchive extension.'))->error();
            }
        }
        else {
            return view('update.step0');
        }
    }

    public function step1() {
        if(get_setting('current_version') == '5.4.2'){
            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '5.4.1'){
            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '5.4'){
            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '5.3'){
            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '5.2'){
            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '5.1'){
            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '5.0'){
            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.9'){
            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.8'){
            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.7'){
            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.6'){
            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.5'){
            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.4'){
            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.3'){
            $sql_path = base_path('sqlupdates/v44.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.2'){
            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v44.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.1'){
            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v44.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '4.0'){
            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v44.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '3.9'){
            $sql_path = base_path('sqlupdates/v40.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v44.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '3.8'){
            $sql_path = base_path('sqlupdates/v39.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v40.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v44.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '3.7'){
            $sql_path = base_path('sqlupdates/v38.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v39.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v40.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v44.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(get_setting('current_version') == '3.6'){
            $sql_path = base_path('sqlupdates/v37.sql');
            DB::unprepared(file_get_contents($sql_path));

            $this->convertCategory();

            $sql_path = base_path('sqlupdates/v38.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v39.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v40.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v44.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v45.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v46.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v47.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v48.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v49.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v50.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v51.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v52.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v53.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v54.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v542.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v543.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        else {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
            $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
            copy($newRouteServiceProvier, $previousRouteServiceProvier);

            return view('update.done');
        }
    }

    public function step2() {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        return view('update.done');
    }

    public function convertTaxes(){
        $tax = Tax::first();

        foreach (Product::all() as $product) {
            $product_tax = new ProductTax;
            $product_tax->product_id = $product->id;
            $product_tax->tax_id = $tax->id;
            $product_tax->tax = $product->tax;
            $product_tax->tax_type = $product->tax_type;
            $product_tax->save();
        }
    }

    public function convertTrasnalations(){
        foreach(\App\Translation::all() as $translation){
            $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($translation->lang_key)));
            $translation->lang_key = $lang_key;
            $translation->save();
        }
    }

    public function convertRatingAndSales(){
        foreach(\App\Seller::all() as $seller){
            $total = 0;
            $rating = 0;
            $num_of_sale = 0;
            try {
                foreach ($seller->user->products as $seller_product) {
                    $total += $seller_product->reviews->count();
                    $rating += $seller_product->reviews->sum('rating');
                    $num_of_sale += $seller_product->num_of_sale;
                }
                if ($total > 0){
                    $seller->rating = $rating/$total;
                    $seller->num_of_reviews = $total;
                }
                $seller->num_of_sale = $num_of_sale;
                $seller->save();
            } catch (\Exception $e) {
                
            }
        }
    }
}
