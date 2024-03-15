import { Component } from "@angular/core";
import { FormControl, FormGroup, Validators } from "@angular/forms";
import Swal from "sweetalert2";
import { AuthService } from "../../auth.service";
import { IBasicResponse } from "src/app/shared/interfaces/IBasicResponse.interface";
import { take } from "rxjs";
import { Router } from "@angular/router";
import { AppService } from "src/app/app.service";

@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.scss"],
})
export class LoginComponent {
  pageLoading: boolean = false;
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

  passwordsVisible = false;

  constructor(
    private authService: AuthService,
    private appService: AppService,
    private router: Router
  ) {}

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

    if (this.registerForm.get("name")?.invalid) {
      Swal.fire(
        "Erro ao Cadastrar",
        "Nome inválido, preencha o campo corretamente para efetuar o cadastro!",
        "error"
      );
      return;
    }
    if (this.registerForm.get("email")?.invalid) {
      Swal.fire(
        "Erro ao Cadastrar",
        "E-mail inválido, preencha o campo corretamente para efetuar o cadastro!",
        "error"
      );
      return;
    }
    if (this.registerForm.get("password")?.invalid) {
      let passwordErrorMsg: string = this.getPasswordMsgByForm(
        this.registerForm
      );

      Swal.fire("Erro ao Cadastrar", passwordErrorMsg, "error");
      return;
    }
    if (this.registerForm.get("passwordConfirm")?.invalid) {
      Swal.fire(
        "Erro ao Cadastrar",
        "A senha e a confirmação não correspondem!",
        "error"
      );
      return;
    }

    let { name, email, password } = this.registerForm.value;
    let user = { name, email, password };
    this.pageLoading = true;
    this.authService
      .register(user)
      .pipe(take(1))
      .subscribe({
        next: (res: IBasicResponse) => {
          this.pageLoading = false;
          Swal.fire("Sucesso", res.message, "success").then(() => {
            this.restart();
          });
        },
        error: (err: Error) => {
          this.pageLoading = false;
          Swal.fire("Erro ao Cadastrar", err.message, "error");
        },
      });
  }

  onLoginUser() {
    this.loginFormSubmited = true;

    if (this.loginForm.get("email")?.invalid) {
      Swal.fire(
        "Erro ao fazer login",
        "E-mail inválido, preencha o campo corretamente para efetuar o login!",
        "error"
      );
      return;
    }

    if (this.loginForm.get("password")?.invalid) {
      let passwordErrorMsg: string = this.getPasswordMsgByForm(this.loginForm);

      Swal.fire("Erro ao fazer Login", passwordErrorMsg, "error");
      return;
    }

    let { email, password } = this.loginForm.value;
    let credentials = { email, password };
    this.pageLoading = true;
    this.authService.login(credentials).subscribe({
      next: () => {
        this.pageLoading = false;
        this.router.navigate(["./home"]);
        this.appService.verifyMenuSubject.next(true);
      },
      error: (err: Error) => {
        this.pageLoading = false;
        Swal.fire("Erro ao fazer Login", err.message, "error");
      },
    });
  }

  onLogin() {
    this.loginClass = this.loginClasses.selected;

    this.loginForm = new FormGroup({
      email: new FormControl(null, [Validators.required, Validators.email]),
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

  getPasswordMsgByForm(form: FormGroup): string {
    let passwordErrorMsg: string = !!form.get("password")?.errors?.["minlength"]
      ? "A senha deve ter no mínimo 6 caracteres"
      : "Senha inválida, preencha o campo corretamente para efetuar o cadastro!";
    return passwordErrorMsg;
  }

  restart() {
    this.loginClass = "";
    this.registerClass = "";
    this.logoClass = "";
    this.registerFormSubmited = false;
    this.loginFormSubmited = false;
    this.passwordsVisible = false;

    this.registerForm.reset();
  }
}
