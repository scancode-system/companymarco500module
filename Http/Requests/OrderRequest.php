<?php

namespace Modules\CompanyMarco500\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function passedValidation(){
        if(!$this->start_end_date){
            $this->merge([
                'start_end_date' => \Carbon\Carbon::now()->format('d/m/Y - d/m/Y')
            ]);
        } 
        if(!$this->order){
            $this->merge([
                'order' => 'name'
            ]);
        }

        $start_end_date = $this->start_end_date;
        $start_end_date = str_replace(' ', '', $start_end_date);
        $start_end_date = explode('-', $start_end_date);
        $start = $this->formatDate($start_end_date[0]);
        $end = $this->formatDate($start_end_date[1]);

        $this->merge([
            'start' => $start,
            'end' => $end.' 23:59:59'
        ]);
    }

    public function formatDate($date){
        $date_splited = explode('/', $date);
        return $date_splited[2].'-'.$date_splited[1].'-'.$date_splited[0];
    }
}
