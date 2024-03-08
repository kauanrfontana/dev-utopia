import { NgModule } from "@angular/core";
import { SharedComponent } from "./shared.component";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { RequiredDirective } from "./directives/Required.directive";
import { MatIconModule } from "@angular/material/icon";
import { HTTP_INTERCEPTORS, HttpClientModule } from "@angular/common/http";
import { InterceptService } from "./services/Intercept.service";
import { CommonModule } from "@angular/common";
import { NavbarComponent } from "./navbar/navbar.component";
import { RouterModule } from "@angular/router";
import { ShoppingCartComponent } from "./shopping-cart/shopping-cart.component";

@NgModule({
  declarations: [
    SharedComponent,
    RequiredDirective,
    NavbarComponent,
    ShoppingCartComponent,
  ],
  imports: [
    FormsModule,
    ReactiveFormsModule,
    MatIconModule,
    HttpClientModule,
    CommonModule,
    RouterModule,
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: InterceptService,
      multi: true,
    },
  ],
  exports: [
    FormsModule,
    ReactiveFormsModule,
    RequiredDirective,
    MatIconModule,
    CommonModule,
    NavbarComponent,
    ShoppingCartComponent,
  ],
})
export class SharedModule {}
