import { Component, OnInit } from "@angular/core";
import { User } from "../shared/models/User";
import { UserService } from "../shared/services/user.service";
import {
  IBasicResponseData,
  IBasicResponseMessage,
} from "../shared/models/IBasicResponse.interfaces";
import Swal from "sweetalert2";
import { LocationSevice, ILocation } from "../shared/services/location.service";
import { IListItem } from "../shared/components/search-select/IListItem.interface";
import { Observable, debounceTime, map } from "rxjs";
import { FormControl } from "@angular/forms";

@Component({
  selector: "app-profile",
  templateUrl: "./profile.component.html",
  styleUrls: ["./profile.component.scss"],
})
export class ProfileComponent implements OnInit {
  isEditing: boolean = false;

  cepControl: FormControl = new FormControl(null);

  user = new User();

  preUserData = new User();

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

    this.cepControlValueChanges();

    this.getStates();

    this.getUserData();
  }

  getUserData() {
    this.userService.getUserData().subscribe({
      next: (res: IBasicResponseData<User>) => {
        this.user = res.data;
        this.cepControl.setValue(this.user.zipCode);
        localStorage.setItem("userData", JSON.stringify(this.user));
        if (this.user.stateId) {
          this.getCitiesByState(this.user.stateId).subscribe({
            next: (res: IBasicResponseData<IListItem[]>) => {
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

  getStates() {
    this.locationService.getStates().subscribe({
      next: (res: IBasicResponseData<ILocation[]>) => {
        this.states = res.data.map((state: { id: number; name: string }) => ({
          id: state.id,
          label: state.name,
        }));
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar países!", err.message, "error");
      },
    });
  }

  cepControlValueChanges() {
    this.cepControl.valueChanges.pipe(debounceTime(1000)).subscribe((value) => {
      if (value.length == 8) {
        this.searchLocationByCep(value);
      }
    });
  }

  getCitiesByState(
    stateId: number
  ): Observable<IBasicResponseData<IListItem[]>> {
    return this.locationService.getCitiesByState(stateId).pipe(
      map((response: IBasicResponseData<ILocation[]>) => {
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

  onStateChange(stateId: number) {
    this.cities = [];
    this.getCitiesByState(stateId).subscribe({
      next: (res: IBasicResponseData<IListItem[]>) => {
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
      next: (
        res: IBasicResponseData<{
          address: string;
          city: string;
          state: string;
        }>
      ) => {
        this.preUserData.address = res.data.address;
        this.preUserData.stateId = Number(
          this.states.find((state) => state.label == res.data.state)?.id
        );
        this.getCitiesByState(this.preUserData.stateId).subscribe({
          next: (res2: IBasicResponseData<IListItem[]>) => {
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
