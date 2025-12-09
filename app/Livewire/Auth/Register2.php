<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: Register.php
 * Created on: 15/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 15/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Initial creation of the component based on Volt template standard. |
 *
 * - ID: 2 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Adaptation of fields to QPK schema (split names, dates) and dynamic routing config. |
 */

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;

class Register2 extends Component
{
    public int $currentStep = 1;

    #[Rule('required|string|min:3|max:255')]
    public string $name = '';

    #[Rule('required|email:rfc,dns|unique:businesses,email')]
    public string $email = '';

    #[Rule('required|min:8|regex:/[A-Z]/|regex:/[0-9]/')]
    public string $password = '';

    public string $passwordConfirmation = '';

    #[Rule('required|min:3')]
    public string $street = '';

    #[Rule('required|max:10')]
    public string $extNumber = '';

    #[Rule('nullable|max:10')]
    public ?string $intNumber = null;

    #[Rule('required|min:3')]
    public string $colony = '';

    #[Rule('required|min:3')]
    public string $city = '';

    #[Rule('required|digits:5')]
    public string $zipCode = '';

    #[Rule('required|digits:10')]
    public string $contactNumber = '';

    #[Rule('required|min:3')]
    public string $municipality = '';

    public array $colonyOptions = [];

    public $latitude = 19.432608;

    public $longitude = -99.133209;

    public bool $isDataObfuscated = false;

    #[Rule('required|in:formal,informal')]
    public string $businessType = 'informal';

    public ?string $rfc = null;

    public ?string $legalName = null;

    public ?string $billingEmail = null;

    public ?string $fiscalRegime = null;

    public ?string $fiscalZipCode = null;

    public ?string $fiscalAddress = null;

    public bool $sameFiscalAddress = false;

    public array $fiscalRegimes = [
        '601' => '601 - General de Ley Personas Morales',
        '603' => '603 - Personas Morales con Fines no Lucrativos',
        '620' => '620 - Sociedades Cooperativas de Producción que optan por diferir sus ingresos',
        '622' => '622 - Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras',
        '623' => '623 - Opcional para Grupos de Sociedades',
        '624' => '624 - Coordinados',
        '605' => '605 - Sueldos y Salarios e Ingresos Asimilados a Salarios',
        '606' => '606 - Arrendamiento',
        '608' => '608 - Demás ingresos',
        '611' => '611 - Ingresos por Dividendos (socios y accionistas)',
        '612' => '612 - Personas Físicas con Actividades Empresariales y Profesionales',
        '614' => '614 - Ingresos por intereses',
        '615' => '615 - Régimen de los ingresos por obtención de premios',
        '621' => '621 - Incorporación Fiscal (RIF)',
        '625' => '625 - Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas',
        '626' => '626 - Régimen Simplificado de Confianza (RESICO)',
    ];

    #[Rule('accepted')]
    public bool $terms = false;

    private array $validationRules = [
        1 => [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc,dns|unique:businesses,email',
            'password' => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/',
            'passwordConfirmation' => 'required|same:password',
        ],
        2 => [
            'street' => 'required|string|max:100',
            'extNumber' => 'required|string|max:10',
            'colony' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'municipality' => 'required|string|max:100',
            'zipCode' => 'required|digits:5',
            'contactNumber' => 'required|string|min:10|max:15',
        ],
        3 => [
            'businessType' => 'required|in:formal,informal',
        ],
        4 => [
            'terms' => 'required|accepted',
        ],
    ];

    /**
     * Initializes the component and redirects if already authenticated.
     */
    public function mount()
    {
        if (Auth::guard('business')->check()) {
            return redirect()->route('ff.dashboard.index');
        }
    }

    /**
     * Navigate to the next step, executing the validation of the current step.
     *
     * @return void
     */
    public function nextStep()
    {
        $rules = $this->validationRules[$this->currentStep];

        if ($this->currentStep === 3) {
            $isFormal = $this->businessType === 'formal';
            $useDifferentAddress = ! $this->sameFiscalAddress;

            $rules = array_merge($rules, [
                'rfc' => ['nullable', 'max:13', \Illuminate\Validation\Rule::requiredIf($isFormal), new ValidRfc],
                'legalName' => ['nullable', 'string', 'max:255', \Illuminate\Validation\Rule::requiredIf($isFormal)],
                'fiscalRegime' => ['nullable', \Illuminate\Validation\Rule::requiredIf($isFormal)],
                'billingEmail' => ['nullable', 'email', \Illuminate\Validation\Rule::requiredIf($isFormal)],
                'fiscalZipCode' => ['nullable', 'digits:5', \Illuminate\Validation\Rule::requiredIf($isFormal && $useDifferentAddress)],
                'fiscalAddress' => ['nullable', 'string', 'max:500', \Illuminate\Validation\Rule::requiredIf($isFormal && $useDifferentAddress)],
            ]);
        }

        $this->validate($rules);

        if ($this->currentStep === 2) {
            $isDuplicate = Business::duplicateCheck(
                $this->name,
                (float) $this->latitude,
                (float) $this->longitude
            )->exists();

            if ($isDuplicate) {
                $this->addError('name', "Ya existe un negocio llamado '{$this->name}' registrado en esta ubicación exacta.");

                session()->flash('error', 'Ubicación duplicada para este nombre de negocio.');

                return;
            }
        }

        if ($this->currentStep < 4) {
            $this->currentStep++;
        }
    }

    /**
     * Return to the previous step.
     *
     * @return void
     */
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function register()
    {
        $this->validate($this->validationRules[4]);

        try {
            // Lógica para construir la dirección y datos fiscales (mantenida)
            $fullAddress = "Calle: {$this->street} #{$this->extNumber}";
            if ($this->intNumber) {
                $fullAddress .= " Int: {$this->intNumber}";
            }
            $fullAddress .= ", Col: {$this->colony}, C.P.: {$this->zipCode}, Ciudad: {$this->city}, Mpio: {$this->municipality}";

            $finalFiscalZip = null;
            $finalFiscalAddress = null;

            if ($this->businessType === 'formal') {
                if ($this->sameFiscalAddress) {
                    $finalFiscalZip = $this->zipCode;
                    $finalFiscalAddress = $fullAddress;
                } else {
                    $finalFiscalZip = $this->fiscalZipCode;
                    $finalFiscalAddress = $this->fiscalAddress;
                }
            }

            $ownerId = User::first()->user_id ?? 1;

            $business = Business::create([
                'owner_id' => $ownerId,
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'address' => $fullAddress,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'contact_number' => $this->contactNumber,
                'business_type' => $this->businessType,
                'plan_id' => null,
                'is_open' => false,

                'rfc' => $this->businessType === 'formal' ? $this->rfc : null,
                'legal_name' => $this->businessType === 'formal' ? $this->legalName : null,
                'fiscal_regime' => $this->businessType === 'formal' ? $this->fiscalRegime : null,
                'billing_email' => $this->businessType === 'formal' ? $this->billingEmail : null,
                'fiscal_zip_code' => $finalFiscalZip,
                'fiscal_address' => $finalFiscalAddress,
            ]);

            $business->paymentMethods()->attach(\App\Models\PaymentMethod::pluck('payment_method_id'), ['is_active' => false]);

            // RUTA ESTÁNDAR: ff.auth.login
            $redirectUrl = route('ff.auth.login');
            $this->dispatch(
                'registration-success',
                redirectUrl: $redirectUrl
            );
        } catch (\Exception $e) {
            $this->addError('general', 'Ocurrió un error interno al registrar el negocio. Por favor intenta nuevamente.');
        }
    }

    /**
     * Renders the view for the component.
     */
    public function render()
    {
        return view('modules.auth.register')->layout('layouts.app');
    }

    /**
     * Define custom validation messages for fields.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre del negocio es obligatorio.',
            'name.unique' => 'El nombre de negocio ya está registrado.',
            'name.min' => 'El campo nombre del negocio debe tener al menos 3 caracteres.',

            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El campo correo electrónico no tiene un formato válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'El campo contraseña debe incluir al menos una mayúscula y un número.',
            'passwordConfirmation.required' => 'El campo confirmar tu contraseña es obligatorio.',
            'passwordConfirmation.same' => 'Las contraseñas no coinciden.',

            'zipCode.required' => 'El campo código postal es obligatorio.',
            'zipCode.digits' => 'El campo código postal debe tener al menos 5 caracteres.',

            'colony.required' => 'La campo colonia es obligatorio.',
            'city.required' => 'El campo estado es obligatorio.',
            'municipality.required' => 'El campo municipio/alcaldía es obligatorio.',

            'street.required' => 'El campo calle es obligatorio.',
            'extNumber.required' => 'El campo número exterior es obligatorio.',
            'contactNumber.required' => 'El campo teléfono es obligatorio.',
            'contactNumber.min' => 'El campo teléfono debe tener al menos 10 caracteres.',

            'businessType.required' => 'Debe seleccionar el tipo de negocio.',
            'rfc.required' => 'El campo RFC es obligatorio.',
            'rfc.max' => 'El campo RFC no debe exceder 13 caracteres.',
            'rfc.regex' => 'El campo RFC no tiene un formato válido.',
            'fiscalRegime.required' => 'El campo régimen fiscal es obligatorio.',
            'legalName.required' => 'El campo razón social es obligatorio.',
            'billingEmail.required' => 'El campo correo de facturación es obligatorio.',
            'billingEmail.email' => 'El campo correo de facturación no tiene un formato válido.',
            'terms.accepted' => 'Debe aceptar los términos de uso y aviso de privacidad para continuar.',
            'terms.required' => 'El campo términos de uso y aviso de privacidad es obligatorio.',
        ];
    }
}
