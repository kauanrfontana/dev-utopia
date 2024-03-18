import { Component, OnInit } from "@angular/core";
import { IUser } from "../shared/interfaces/IUser.interface";
import { UserService } from "../shared/services/user.service";
import { IBasicResponse } from "../shared/interfaces/IBasicResponse.interface";
import Swal from "sweetalert2";
import { FormControl, FormGroup, Validators } from "@angular/forms";

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

  countries: any = [
    {id: 1, label: "Brasil"},
    {id: 3, label: "Afeganistao"},
    {id: 2, label: "Irlanda"}
  ]

  loadingUserData: boolean = false;

  userForm: FormGroup = new FormGroup({
    name: new FormControl(""),
    email: new FormControl(""),
  });

  constructor(private userService: UserService) {
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
