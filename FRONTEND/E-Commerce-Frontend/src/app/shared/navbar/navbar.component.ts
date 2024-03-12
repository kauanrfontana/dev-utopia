import { Component, ElementRef, HostListener, ViewChild } from "@angular/core";
import { AppService } from "src/app/app.service";
import { AuthService } from "src/app/auth/auth.service";

interface INavItem {
  icon: string;
  route: string;
  label: string;
}

@Component({
  selector: "app-navbar",
  templateUrl: "./navbar.component.html",
  styleUrls: ["./navbar.component.scss"],
})
export class NavbarComponent {
  showingNavbar: boolean = true;

  navItems: INavItem[] = [
    {
      icon: "home",
      route: "/home",
      label: "Home",
    },
    {
      icon: "shopping_basket",
      route: "/products",
      label: "Produtos",
    },
  ];

  @ViewChild("navContainer") navContainer?: ElementRef;
  firstView: boolean = true;

  constructor(private authService: AuthService, private appService: AppService) {}

  @HostListener("mouseenter") mouseover(eventData: Event) {
    this.showingNavbar = true;
    this.firstView = false;
  }
  @HostListener("mouseleave") mouseleave(eventData: Event) {
    this.showingNavbar = false;
  }

  onLogout() {
    this.showingNavbar = false;
    this.appService.verifyMenuSubject.next(false);
    this.authService.logout();
  }
}
