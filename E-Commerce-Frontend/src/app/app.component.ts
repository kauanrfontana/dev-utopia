import { Component, OnDestroy, OnInit } from "@angular/core";
import { AppService } from "./app.service";
import { Subscription } from "rxjs";

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html",
  styleUrls: ["./app.component.scss"],
})
export class AppComponent implements OnInit, OnDestroy {
  subscriptionVerifyMenuSubject?: Subscription;
  showMenus: boolean = false;

  constructor(private appService: AppService) {
    this.showMenus = window.location.pathname !== "/auth";
  }

  ngOnInit(): void {
    this.subscriptionVerifyMenuSubject =
      this.appService.verifyMenuSubject.subscribe({
        next: (showMenu: boolean) => {
          this.showMenus = showMenu;
        },
      });
  }

  ngOnDestroy(): void {
    this.subscriptionVerifyMenuSubject?.unsubscribe();
  }
}
