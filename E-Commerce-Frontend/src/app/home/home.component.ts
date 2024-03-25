import { AuthService } from "src/app/auth/auth.service";
import { IBasicResponse } from "../shared/models/IBasicResponse.interface";
import { UserService } from "./../shared/services/user.service";
import { Component, OnInit } from "@angular/core";

@Component({
  selector: "app-home",
  templateUrl: "./home.component.html",
  styleUrls: ["./home.component.scss"],
})
export class HomeComponent implements OnInit {
  constructor(
    private userService: UserService,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    this.setUserData();
  }

  setUserData() {
    this.userService.getUserData().subscribe({
      next: (res: IBasicResponse) => {
        const userData = res.data.user;
        localStorage.setItem("userData", JSON.stringify(userData));
      },
      error: () => {
        this.authService.logout();
      },
    });
  }
}
