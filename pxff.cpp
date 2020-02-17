#include<stdio.h>
int main(){
   unsigned char d[36884];
   long int i;
   long pos=36867L;
   FILE * fp=fopen("savegame.dat","rb");
   fread(d,1,36884L,fp);

   d[pos+0]=d[pos+1]=d[pos+2]=255;
   fclose(fp);
   fp=fopen("savegame.dat","wb");
   fwrite(d,1,36884L,fp);
   fclose(fp);
   return 0;
}
