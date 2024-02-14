import { Component } from "@angular/core";
import { FormControl, FormGroup, Validators } from "@angular/forms";
import Swal from "sweetalert2";

@Component({
  selector: "app-auth",
  templateUrl: "./auth.component.html",
  styleUrls: ["./auth.component.scss"],
})
export class AuthComponent {
  inLogin: boolean = false;
  inRegister: boolean = false;

  registerClasses = {
    preview: "container-register-preview",
    selected: "register-page",
  };
  registerClass: string = "";
  loginClasses = {
    preview: "container-login-preview",
    selected: "login-page",
  };
  loginClass: string = "";
  logoClasses = {
    right: "logo-right",
  };
  logoClass: string = "";

  registerForm: FormGroup = new FormGroup({});
  loginForm: FormGroup = new FormGroup({});

  registerFormSubmited: boolean = false;
  loginFormSubmited: boolean = false;

  constructor() {}

  onPreviewRegister() {
    if (this.registerClass === this.registerClasses.selected) return;
    this.registerClass =
      this.registerClass == this.registerClasses.preview
        ? ""
        : this.registerClasses.preview;

    this.logoClass =
      this.logoClass == this.logoClasses.right ? "" : this.logoClasses.right;
  }

  onPreviewLogin() {
    if (this.loginClass === this.loginClasses.selected) return;
    this.loginClass =
      this.loginClass == this.loginClasses.preview
        ? ""
        : this.loginClasses.preview;
  }

  onRegister() {
    this.registerClass = this.registerClasses.selected;

    this.registerForm = new FormGroup({
      name: new FormControl(null, Validators.required),
      email: new FormControl(null, [Validators.email, Validators.required]),
      password: new FormControl(null, [
        Validators.required,
        Validators.minLength(6),
      ]),
      passwordConfirm: new FormControl(null, [
        Validators.required,
        this.passwordMatch.bind(this),
      ]),
    });
  }

  onRegisterUser() {
    this.registerFormSubmited = true;

    if (this.registerForm.invalid) {
      Swal.fire("Erro", "Preencha todos os campos corretamente", "error");
      return;
    }
  }

  onLogin() {
    this.loginClass = this.loginClasses.selected;

    this.loginForm = new FormGroup({
      user: new FormControl(null, Validators.required),
      password: new FormControl(null, [
        Validators.required,
        Validators.minLength(6),
      ]),
    });
  }

  passwordMatch(control: FormControl): { [s: string]: boolean } {
    if (control.value !== this.registerForm.get("password")?.value) {
      return { passwordDoesntMatch: true };
    }
    return {};
  }

  restart() {
    this.loginClass = "";
    this.registerClass = "";
    this.logoClass = "";
    this.registerFormSubmited = false;
    this.loginFormSubmited = false;

    this.registerForm.reset();
  }
}
