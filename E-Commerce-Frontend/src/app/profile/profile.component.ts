import { Component, OnInit } from "@angular/core";
import { User } from "../shared/models/User";
import { UserService } from "../shared/services/user.service";
import {
  IBasicResponseData,
  IBasicResponseMessage,
} from "../shared/models/IBasicResponse.interfaces";
import Swal from "sweetalert2";

@Component({
  selector: "app-profile",
  templateUrl: "./profile.component.html",
  styleUrls: ["./profile.component.scss"],
})
export class ProfileComponent implements OnInit {
  isEditing: boolean = false;
  btnHover: boolean = false;

  user = new User();

  currentPassword: string = "";
  newPassword: string = "";

  loadingUserData: boolean = false;
  loadingLocationData: boolean = false;

  constructor(
    private userService: UserService,
  ) {}

  ngOnInit(): void {
    this.loadingUserData = true;
    this.isEditing = false;

    this.getUserData();
  }

 

  getUserData() {
    this.userService.getUserData().subscribe({
      next: (res: IBasicResponseData<User>) => {
        this.user.setUserData(res.data);
        localStorage.setItem("userData", JSON.stringify(this.user));
        this.loadingUserData = false;

      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar usuário!", err.message, "error");
        this.loadingUserData = false;
      },
    });
  }

  verifyIsLoading(): boolean {
    return this.loadingUserData || this.loadingLocationData;
  }


  onUpdateUserData() {
    this.userService.updateUserData(this.user).subscribe({
      next: (res: IBasicResponseMessage) => {
        Swal.fire("Sucesso", res.message, "success").then(() => {
          this.ngOnInit();
        });
      },
      error: (err: Error) => {
        Swal.fire("Erro ao atualizar usuário!", err.message, "error");
      },
    });
  }

  onUpdatePassword() {
    Swal.fire({
      title: "Alteração de Senha",
      html: `
          <div class="form-group" style="margin: 1rem;">
          <input
            type="text"
            class="form-control"
            placeholder=""
            id="currentPassword"
          />
          <label>Senha Atual</label>
          </div>
          <div class="form-group" style="margin: 1rem;">
          <input
            type="text"
            class="form-control"
            placeholder=""
            id="newPassword"
          />
          <label>Nova Senha</label>
          </div>
      `,
      confirmButtonText: "Alterar",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      showLoaderOnConfirm: true,
      preConfirm: () => {},
    }).then((result) => {
      if (result.dismiss) {
        return;
      }

      this.userService
        .updatePassword({
          currentPassword: this.currentPassword,
          newPassword: this.newPassword,
        })
        .subscribe({
          next: (res: IBasicResponseMessage) => {
            Swal.fire("Sucesso", res.message, "success");
          },
          error: (err: Error) => {
            Swal.fire("Erro ao atualizar senha!", err.message, "error");
          },
        });
    });

    const $currentPasswordInput = document.getElementById(
      "currentPassword"
    ) as HTMLInputElement;
    $currentPasswordInput?.addEventListener("input", () => {
      this.currentPassword = $currentPasswordInput.value;
    });
    const $newPasswordInput = document.getElementById(
      "newPassword"
    ) as HTMLInputElement;
    $newPasswordInput?.addEventListener("input", () => {
      this.newPassword = $newPasswordInput.value;
    });
  }

  updateRoleToSeller() {
    this.userService.updateUserRole(2).subscribe({
      next: (res: IBasicResponseMessage) => {
        Swal.fire("Sucesso", res.message, "success").then(() => {
          this.ngOnInit();
        });
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar cep!", err.message, "error");
      },
    });
  }

  changeEditState() {
    if(this.isEditing){
      this.ngOnInit();
    }
    this.isEditing = !this.isEditing;
  }

}
