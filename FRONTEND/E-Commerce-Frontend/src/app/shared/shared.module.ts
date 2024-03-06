import { NgModule } from "@angular/core";
import { SharedComponent } from "./shared.component";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { RequiredDirective } from "./directives/Required.directive";
import { MatIconModule } from "@angular/material/icon";
import { HTTP_INTERCEPTORS, HttpClientModule } from "@angular/common/http";
import { InterceptService } from "./services/Intercept.service";

@NgModule({
  declarations: [SharedComponent, RequiredDirective],
  imports: [FormsModule, ReactiveFormsModule, MatIconModule, HttpClientModule],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: InterceptService,
      multi: true,
    },
  ],
  exports: [FormsModule, ReactiveFormsModule, RequiredDirective, MatIconModule],
})
export class SharedModule {}
