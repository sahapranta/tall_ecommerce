<?php

namespace App\Http\Livewire;

use App\Models\Subscriber;
use Livewire\Component;
use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Http;

class SubscriptionForm extends Component
{
    public $email;
    public $captcha;
    public $success = false;

    protected function rules()
    {
        return [
            // 'captcha' => ['required', new Recaptcha],
            'email' => ['required', 'email', 'max:255', 'unique:subscribers'],
        ];
    }



    public function submit($token = null)
    {
        $errors = $this->getErrorBag();
        if (is_null($token)) {
            $errors->add('email', 'Reload your browser to satisfy reCaptcha.');
        }


        // if()
        // // $this->fill(['captcha' => $token ?? null]);
        // $this->success = $this->validate();

        $data = array(
            'secret' => config('extra.recaptcha_secret'),
            'response' => $token
        );

        $response = Http::withoutVerifying()->post('https://www.google.com/recaptcha/api/siteverify?' . http_build_query($data));
        $result = $response->json();

        if (
            $result['success'] === false || $result['score'] < 0.3
        ) {
            $errors->add('email', 'Reload your browser to satisfy reCaptcha.');
        }

        $data = $this->validateOnly('email');
        if ($data['email']) {
            Subscriber::create(['email' => $data['email']]);
            $this->emit('openModal', 'shop.thank-you');
            $this->reset('email');
            $this->resetErrorBag('email');
        }
    }

    public function render()
    {
        return view('livewire.subscription-form');
    }
}
