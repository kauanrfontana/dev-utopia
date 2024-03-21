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
import { NgxMatSelectSearchModule } from "ngx-mat-select-search";
import {
  IConfig,
  NgxMaskDirective,
  NgxMaskPipe,
  provideEnvironmentNgxMask,
} from "ngx-mask";
import { LabelClue } from "./components/label-clue/label-clue.component";

const maskConfigFunction: () => Partial<IConfig> = () => {
  return {
    validation: false,
  };
};
@NgModule({
  declarations: [
    SharedComponent,
    RequiredDirective,
    NavbarComponent,
    ShoppingCartComponent,
    LoaderDots,
    SearchSelectComponent,
    LabelClue,
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
    NgxMatSelectSearchModule,
    NgxMaskDirective,
    NgxMaskPipe,
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: InterceptService,
      multi: true,
    },
    provideEnvironmentNgxMask(maskConfigFunction),
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
    NgxMaskDirective,
    NgxMaskPipe,
    LabelClue,
  ],
})
export class SharedModule {}
