import { NgModule } from "@angular/core";
import { SharedModule } from "../shared/shared.module";
import { AuthComponent } from "./auth.component";
import { CommonModule } from "@angular/common";

@NgModule({
  declarations: [AuthComponent],
  imports: [SharedModule, CommonModule],
})
export class AuthModule {}
