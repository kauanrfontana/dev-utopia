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
import { LoaderDots } from "./components/loaderDots/loaderDots.component";
import { MatFormFieldModule } from "@angular/material/form-field";
import { MatSelectModule } from "@angular/material/select";
import { SearchSelectComponent } from "./components/search-select/search-select.component";
@NgModule({
  declarations: [
    SharedComponent,
    RequiredDirective,
    NavbarComponent,
    ShoppingCartComponent,
    LoaderDots,
    SearchSelectComponent,
  ],
  imports: [
    FormsModule,
    ReactiveFormsModule,
    MatIconModule,
    HttpClientModule,
    CommonModule,
    RouterModule,
    MatFormFieldModule,
    MatSelectModule,
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
    LoaderDots,
    SearchSelectComponent,
    MatFormFieldModule,
    MatSelectModule,
  ],
})
export class SharedModule {}
