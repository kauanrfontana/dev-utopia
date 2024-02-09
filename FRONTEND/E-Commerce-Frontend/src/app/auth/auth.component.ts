import { Component } from "@angular/core";

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
    selected: "",
  };
  registerClass: string = "";
  loginClasses = {
    preview: "container-login-preview",
    selected: "",
  };
  loginClass: string = "";
  welcomeClasses = {
    left: "container-welcome-left",
    right: "container-welcome-right",
  };
  welcomeClass: string = "";

  constructor() {}

  onPreviewRegister() {
    this.registerClass =
      this.registerClass == this.registerClasses.preview
        ? ""
        : this.registerClasses.preview;
  }

  onPreviewLogin() {
    this.loginClass =
      this.loginClass == this.loginClasses.preview
        ? ""
        : this.loginClasses.preview;
  }
}
