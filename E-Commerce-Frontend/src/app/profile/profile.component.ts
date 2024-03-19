import { Component, OnInit } from "@angular/core";
import { IUser } from "../shared/interfaces/IUser.interface";
import { UserService } from "../shared/services/user.service";
import { IBasicResponse } from "../shared/interfaces/IBasicResponse.interface";
import Swal from "sweetalert2";
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { LocationSevice } from "../shared/services/location.service";
import { IListItem } from "../shared/components/search-select/IListItem.interface";

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
    state_id: "",
    city_id: "",
    address: "",
    houseNumber: "",
    complement: "",
    zipCode: "",
    roles: [],
  };

  preUserData: IUser = {
    name: "",
    email: "",
    state_id: "",
    city_id: "",
    address: "",
    houseNumber: "",
    complement: "",
    zipCode: "",
    roles: [],
  };

  states: IListItem[] = [];
  cities: IListItem[] = [];

  loadingUserData: boolean = false;

  constructor(
    private userService: UserService,
    private locationService: LocationSevice
  ) {}

  ngOnInit(): void {
    this.loadingUserData = true;

    this.locationService.getStates().subscribe({
      next: (res: IBasicResponse) => {
        this.states = res.data.map((state: { id: number; name: string }) => ({
          id: state.id.toString(),
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
        if (this.user.state_id) {
          this.getCitiesByState(this.user.state_id);
        }
        this.loadingUserData = false;
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar usuário!", err.message, "error");
        this.loadingUserData = false;
      },
    });
  }

  getCitiesByState(stateId: string) {
    this.cities = [];
    this.locationService.getCitiesByState(stateId).subscribe({
      next: (res: IBasicResponse) => {
        this.cities = res.data.map((city: { id: number; name: string }) => ({
          id: city.id.toString(),
          label: city.name,
        }));
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar cidades!", err.message, "error");
      },
    });
  }

  changeEditState() {
    this.preUserData = { ...this.user };
    this.isEditing = !this.isEditing;
  }

  getStateLabelById(id: string): string | undefined {
    return this.states.find((state) => state?.id == +id)?.label;
  }

  getCityLabelById(id: string): string | undefined {
    return this.cities.find((city) => city?.id == +id)?.label;
  }
}
