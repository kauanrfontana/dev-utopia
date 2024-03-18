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
    country: "",
    state: "",
    city: "",
    neighborhood: "",
    streetAvenue: "",
    houseNumber: "",
    complement: "",
    zipCode: "",
    roles: [],
  };

  countries: IListItem[] = [];

  loadingUserData: boolean = false;

  userForm: FormGroup = new FormGroup({
    name: new FormControl(""),
    email: new FormControl(""),
  });

  constructor(
    private userService: UserService,
    private locationService: LocationSevice
  ) {
    this.initUserForm();
  }

  ngOnInit(): void {
    this.loadingUserData = true;
    this.userService.getUserData().subscribe({
      next: (res: IBasicResponse) => {
        this.user = res.data.user;
        this.loadingUserData = false;
        this.userForm?.setValue({
          name: this.user.name,
          email: this.user.email,
        });
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar usuário!", err.message, "error");
        this.loadingUserData = false;
      },
    });
    this.locationService.getCountries().subscribe({
      next: (res: IBasicResponse) => {
        this.countries = res.data.map((c: { id: number; name: string }) => ({
          id: c.id,
          label: c.name,
        }));
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar países!", err.message, "error");
      },
    });
  }

  initUserForm() {
    this.userForm = new FormGroup({
      name: new FormControl(null, Validators.required),
      email: new FormControl(null, [Validators.email, Validators.required]),
    });
  }

  changeEditState() {
    this.isEditing = !this.isEditing;
  }
}
