import { Component, OnInit } from "@angular/core";
import { IUser } from "../shared/interfaces/IUser.interface";

@Component({
  selector: "app-profile",
  templateUrl: "./profile.component.html",
  styleUrls: ["./profile.component.scss"],
})
export class ProfileComponent implements OnInit {
  isSeller: boolean = false;
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
  };

  constructor() {}

  ngOnInit(): void {}
}
