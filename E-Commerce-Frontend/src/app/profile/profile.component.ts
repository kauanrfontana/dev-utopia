import { Component, OnInit } from "@angular/core";
import { IUser } from "../shared/interfaces/IUser.interface";
import { UserService } from "../shared/services/user.service";
import { IBasicResponse } from "../shared/interfaces/IBasicResponse.interface";
import Swal from "sweetalert2";
import { LocationSevice } from "../shared/services/location.service";
import { IListItem } from "../shared/components/search-select/IListItem.interface";
import { Observable, map } from "rxjs";

@Component({
  selector: "app-profile",
  templateUrl: "./profile.component.html",
  styleUrls: ["./profile.component.scss"],
})
export class ProfileComponent implements OnInit {
  isSeller: boolean = false;
  isEditing: boolean = false;

  user: IUser = {
    name: "",
    email: "",
    stateId: 0,
    cityId: 0,
    address: "",
    houseNumber: "",
    complement: "",
    zipCode: "",
    roles: [],
  };

  preUserData: IUser = {
    name: "",
    email: "",
    stateId: 0,
    cityId: 0,
    address: "",
    houseNumber: "",
    complement: "",
    zipCode: "",
    roles: [],
  };

  states: IListItem[] = [];
  cities: IListItem[] = [];

  currentPassword: string = "";
  newPassword: string = "";

  loadingUserData: boolean = false;
  loadingCepSearch: boolean = false;

  constructor(
    private userService: UserService,
    private locationService: LocationSevice
  ) {}

  ngOnInit(): void {
    this.loadingUserData = true;
    this.isEditing = false;

    this.locationService.getStates().subscribe({
      next: (res: IBasicResponse) => {
        this.states = res.data.map((state: { id: number; name: string }) => ({
          id: state.id,
          label: state.name,
        }));
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar países!", err.message, "error");
      },
    });

    this.userService.getUserData().subscribe({
      next: (res: IBasicResponse) => {
        this.user = res.data.user;
        if (this.user.stateId) {
          this.getCitiesByState(this.user.stateId).subscribe({
            next: (res: IBasicResponse) => {
              this.cities = res.data;
              this.loadingUserData = false;
            },
            error: (err: Error) => {
              Swal.fire("Erro ao consultar cidades!", err.message, "error");
              this.loadingUserData = false;
            },
          });
        } else {
          this.loadingUserData = false;
        }
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar usuário!", err.message, "error");
        this.loadingUserData = false;
      },
    });
  }

  getCitiesByState(stateId: number): Observable<IBasicResponse> {
    return this.locationService.getCitiesByState(stateId).pipe(
      map((response: IBasicResponse) => {
        return {
          data: response.data.map((city: { id: number; name: string }) => ({
            id: city.id,
            label: city.name,
          })),
        };
      })
    );
  }

  onUpdateUserData() {
    this.userService.updateUserData(this.preUserData).subscribe({
      next: (res: IBasicResponse) => {
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
          next: (res: IBasicResponse) => {
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

  onStateChange(stateId: number) {
    this.cities = [];
    this.getCitiesByState(stateId).subscribe({
      next: (res: IBasicResponse) => {
        this.cities = res.data;
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar cidades!", err.message, "error");
      },
    });
  }

  searchLocationByCep(cep: string) {
    this.loadingCepSearch = true;

    this.locationService.getLocationByCep(cep).subscribe({
      next: (res: IBasicResponse) => {
        this.preUserData.address = res.data.address;
        this.preUserData.stateId = Number(
          this.states.find((state) => state.label == res.data.state)?.id
        );
        this.getCitiesByState(this.preUserData.stateId).subscribe({
          next: (res2: IBasicResponse) => {
            this.cities = res2.data;
            this.preUserData.cityId = Number(
              this.cities.find((city) => city.label == res.data.city)?.id
            );
            this.loadingCepSearch = false;
          },
          error: (err: Error) => {
            Swal.fire("Erro ao consultar cidades!", err.message, "error");
          },
        });
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar cep!", err.message, "error");
        this.loadingCepSearch = false;
      },
    });
  }

  changeEditState() {
    this.preUserData = { ...this.user };
    this.isEditing = !this.isEditing;
  }

  getStateLabelById(id: number): string | undefined {
    return this.states.find((state) => state?.id == +id)?.label;
  }

  getCityLabelById(id: number): string | undefined {
    return this.cities.find((city) => city?.id == +id)?.label;
  }
}
