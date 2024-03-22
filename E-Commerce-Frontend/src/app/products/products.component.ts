import { Component, OnInit } from "@angular/core";
import { UserService } from "../shared/services/user.service";

@Component({
  selector: "app-products",
  templateUrl: "./products.component.html",
  styleUrls: ["./products.component.scss"],
})
export class ProductsComponent implements OnInit {
  tabs: any = [];
  roleCategory: number = 0;

  constructor(private userService: UserService) {
    this.roleCategory = this.userService.userData().roleCategory;
  }

  ngOnInit(): void {
    this.tabs = [
      { path: "/products", name: "Produtos", showIf: true },
      {
        path: "/products/my",
        name: "Meus Produtos",
        showIf: this.roleCategory > 1,
      },
    ];
  }
}
